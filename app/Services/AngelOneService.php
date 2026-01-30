<?php
namespace App\Services;

use GuzzleHttp\Client;
use OTPHP\TOTP;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Add this at the top
class AngelOneService
{
    private Client $client;
    private string $baseUrl;
    private string $marketBaseUrl;
    private string $cachePrefix;
    private int $jwtTtlSeconds;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'connect_timeout' => 10,
        ]);

        $this->baseUrl = config('services.angel.base_url', env('ANGEL_BASE_URL', 'https://apiconnect.angelbroking.com'));
        $this->marketBaseUrl = config('services.angel.market_base_url', env('ANGEL_MARKET_BASE_URL', 'https://apiconnect.angelone.in'));
        $this->cachePrefix = 'angel_';
        $this->jwtTtlSeconds = intval(config('services.angel.jwt_ttl_seconds', 3300));
    }

    /**
     * Login and cache jwt/feed
     */
    public function login(): array
    {
        $totp = TOTP::create(config('services.angel.totp_secret', env('ANGEL_TOTP_SECRET')))->now();

        $payload = [
            'clientcode' => config('services.angel.client_code', env('ANGEL_CLIENT_CODE')),
            'password'   => config('services.angel.password', env('ANGEL_PASSWORD')),
            'totp'       => $totp,
        ];

        $res = $this->client->post("{$this->baseUrl}/rest/auth/angelbroking/user/v1/loginByPassword", [
            'headers' => [
                'X-PrivateKey' => config('services.angel.api_key', env('ANGEL_API_KEY')),
                'X-UserType'    => 'USER',
                'X-SourceID'    => 'WEB',
                'X-ClientLocalIP' => '127.0.0.1',
                'X-ClientPublicIP' => '127.0.0.1',
                'X-MACAddress' => '00:00:00:00:00:00',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => $payload,
            'http_errors' => false,
        ]);

        $body = (string) $res->getBody();
        $data = json_decode($body, true) ?: [];

        if (empty($data['status']) || !$data['status']) {
            $msg = $data['message'] ?? 'Angel login failed';
            throw new Exception($msg);
        }

        $jwt = $data['data']['jwtToken'] ?? null;
        $feed = $data['data']['feedToken'] ?? null;

        if (!$jwt) {
            throw new Exception('No JWT returned from Angel login');
        }

        Cache::put($this->cachePrefix . 'jwt', $jwt, $this->jwtTtlSeconds);
        if ($feed) {
            Cache::put($this->cachePrefix . 'feed', $feed, $this->jwtTtlSeconds);
        }

        return $data;
    }

    protected function getJwt(): ?string
    {
        return Cache::get($this->cachePrefix . 'jwt');
    }

    protected function ensureLoggedIn(): void
    {
        if (!$this->getJwt()) {
            $this->login();
        }
    }

    public function getMaxDaysForInterval(string $interval): int
    {
        $map = [
            'ONE_MINUTE'    => 30,
            'THREE_MINUTE'  => 60,
            'FIVE_MINUTE'   => 100,
            'TEN_MINUTE'    => 100,
            'FIFTEEN_MINUTE'=> 200,
            'THIRTY_MINUTE' => 200,
            'ONE_HOUR'      => 400,
            'ONE_DAY'       => 2000,
        ];
        $intervalUpper = strtoupper($interval);
        return $map[$intervalUpper] ?? 30;
    }

    public function historical(string $symbolToken, string $interval, ?string $from, ?string $to): array
    {
        try {
            $this->ensureLoggedIn();
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Login failed: ' . $e->getMessage(), 'data' => null];
        }

        $intervalUpper = strtoupper($interval);
        $maxDays = $this->getMaxDaysForInterval($intervalUpper);

        $tz = config('app.timezone', 'Asia/Kolkata') ?: 'Asia/Kolkata';
        $now = Carbon::now($tz);

        $toDt = $to ? Carbon::createFromFormat('Y-m-d H:i', $to, $tz)->startOfMinute() : $now->startOfMinute();
        $fromDt = $from ? Carbon::createFromFormat('Y-m-d H:i', $from, $tz)->startOfMinute() : (clone $toDt)->subDays($maxDays)->setTime(9, 15);

        if ($fromDt->gt($toDt)) {
            [$fromDt, $toDt] = [$toDt, $fromDt];
        }

        $combined = [];
        $current = $fromDt->copy();
        $jwt = $this->getJwt();

        try {
            while ($current->lte($toDt)) {
                $chunkEnd = $current->copy()->addDays($maxDays - 1)->endOfDay();
                if ($chunkEnd->gt($toDt)) {
                    $chunkEnd = $toDt->copy();
                }

                $payload = [
                    'exchange' => 'NSE',
                    'symboltoken' => (string)$symbolToken,
                    'interval' => $intervalUpper,
                    'fromdate' => $current->format('Y-m-d H:i'),
                    'todate' => $chunkEnd->format('Y-m-d H:i'),
                ];

                $res = $this->client->post("{$this->baseUrl}/rest/secure/angelbroking/historical/v1/getCandleData", [
                    'headers' => [
                        'X-PrivateKey' => config('services.angel.api_key', env('ANGEL_API_KEY')),
                        'X-UserType' => 'USER',
                        'X-SourceID' => 'WEB',
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $jwt,
                        'X-ClientLocalIP' => '127.0.0.1',
                        'X-ClientPublicIP' => '127.0.0.1',
                        'X-MACAddress' => '00:00:00:00:00:00',
                    ],
                    'json' => $payload,
                    'http_errors' => false,
                    'timeout' => 60,
                ]);

                $body = (string) $res->getBody();
                $raw = json_decode($body, true) ?: [];

                if (empty($raw) || !isset($raw['status']) || !$raw['status']) {
                    if (isset($raw['errorcode']) && in_array($raw['errorcode'], ['401', '403'])) {
                        Cache::forget($this->cachePrefix . 'jwt');
                        $this->login();
                        $jwt = $this->getJwt();
                        continue;
                    }

                    return [
                        'status' => false,
                        'message' => $raw['message'] ?? 'Historical API returned error for chunk',
                        'errorcode' => $raw['errorcode'] ?? null,
                        'raw' => $raw,
                        'data' => null,
                    ];
                }

                if (!empty($raw['data']) && is_array($raw['data'])) {
                    foreach ($raw['data'] as $r) {
                        $combined[] = $r;
                    }
                }

                if (count($combined) > 500000) {
                    break;
                }

                $current = $chunkEnd->copy()->addSecond();
            }

            $candles = [];
            $seen = [];

            foreach ($combined as $row) {
                if (!isset($row[0])) continue;

                try {
                    $ts = Carbon::parse($row[0], $tz)->timestamp;
                } catch (Exception $e) {
                    continue;
                }

                if (isset($seen[$ts])) continue;
                $seen[$ts] = true;

                $open  = isset($row[1]) ? (float)$row[1] : 0.0;
                $high  = isset($row[2]) ? (float)$row[2] : $open;
                $low   = isset($row[3]) ? (float)$row[3] : $open;
                $close = isset($row[4]) ? (float)$row[4] : $open;

                $candles[] = [
                    'time' => $ts,
                    'open' => $open,
                    'high' => $high,
                    'low' => $low,
                    'close' => $close,
                ];
            }

            usort($candles, fn($a, $b) => $a['time'] <=> $b['time']);

            return ['status' => true, 'message' => 'OK', 'data' => $candles];
        } catch (Exception $e) {
            Log::error('Angel historical exception: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Exception: ' . $e->getMessage(), 'data' => null];
        }
    }

    public function quote(array $symbols, string $mode = 'FULL', string $exchange = 'NSE'): array
    {
        $symbols = array_values(array_filter(array_map('strval', $symbols)));
        if (empty($symbols)) {
            return ['status' => false, 'message' => 'No symbols provided', 'data' => null];
        }

        try {
            $this->ensureLoggedIn();
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Login failed: ' . $e->getMessage(), 'data' => null];
        }

        $payload = [
            'mode' => strtoupper($mode),
            'exchangeTokens' => [
                strtoupper($exchange) => $symbols
            ]
        ];

        $jwt = $this->getJwt();

        try {
            $res = $this->client->post("{$this->marketBaseUrl}/rest/secure/angelbroking/market/v1/quote/", [
                'headers' => [
                    'X-PrivateKey' => config('services.angel.api_key', env('ANGEL_API_KEY')),
                    'X-UserType' => 'USER',
                    'X-SourceID' => 'WEB',
                    'Authorization' => 'Bearer ' . $jwt,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-ClientLocalIP' => '127.0.0.1',
                    'X-ClientPublicIP' => '127.0.0.1',
                    'X-MACAddress' => '00:00:00:00:00:00',
                ],
                'json' => $payload,
                'http_errors' => false,
                'timeout' => 20,
            ]);

            $body = (string)$res->getBody();
            $raw = json_decode($body, true) ?: [];

            if (empty($raw) || !isset($raw['status']) || !$raw['status']) {
                if (isset($raw['errorcode']) && in_array($raw['errorcode'], ['401','403'])) {
                    Cache::forget($this->cachePrefix . 'jwt');
                    $this->login();
                    return $this->quote($symbols, $mode, $exchange);
                }

                return ['status' => false, 'message' => $raw['message'] ?? 'Quote API error', 'raw' => $raw, 'data' => null];
            }

            return ['status' => true, 'message' => 'SUCCESS', 'data' => $raw['data'] ?? $raw];
        } catch (Exception $e) {
            Log::error('Angel quote exception: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Exception: ' . $e->getMessage(), 'data' => null];
        }
    }

    /**
     * Get Gainers and Losers
     */
    public function gainersLosers(string $datatype, string $exchange, string $expirytype): array
    {
        try {
            $this->ensureLoggedIn();
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Login failed: ' . $e->getMessage(), 'data' => null];
        }

        $payload = [
            'datatype' => $datatype,
            'expirytype' => $expirytype
        ];

        if (!empty($exchange)) {
            $payload['exchange'] = $exchange;
        }

        $jwt = $this->getJwt();

        try {
            $res = $this->client->post("{$this->marketBaseUrl}/rest/secure/angelbroking/marketData/v1/gainersLosers", [
                'headers' => [
                    'X-PrivateKey' => config('services.angel.api_key', env('ANGEL_API_KEY')),
                    'X-UserType' => 'USER',
                    'X-SourceID' => 'WEB',
                    'Authorization' => 'Bearer ' . $jwt,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-ClientLocalIP' => '127.0.0.1',
                    'X-ClientPublicIP' => '127.0.0.1',
                    'X-MACAddress' => '00:00:00:00:00:00',
                ],
                'json' => $payload,
                'http_errors' => false,
                'timeout' => 20,
            ]);

            $body = (string)$res->getBody();
            $raw = json_decode($body, true) ?: [];

            if (empty($raw) || !isset($raw['status']) || !$raw['status']) {
                if (isset($raw['errorcode']) && in_array($raw['errorcode'], ['401', '403'])) {
                    Cache::forget($this->cachePrefix . 'jwt');
                    $this->login();
                    // Retry once
                    return $this->gainersLosers($datatype, $exchange, $expirytype);
                }
                return ['status' => false, 'message' => $raw['message'] ?? 'Gainers/Losers API error', 'raw' => $raw, 'data' => null];
            }

            return ['status' => true, 'message' => 'SUCCESS', 'data' => $raw['data'] ?? []];

        } catch (Exception $e) {
            Log::error('Angel gainersLosers exception: ' . $e->getMessage());
            return ['status' => false, 'message' => 'Exception: ' . $e->getMessage(), 'data' => null];
        }
    }


    public function fetch52WeekHighLow(array $symbols, string $exchange = 'NSE'): array
    {
        return $this->quote($symbols, 'FULL', $exchange);
    }


    public function wsToken(): array
    {
        $jwt = Cache::get($this->cachePrefix . 'jwt');
        $feed = Cache::get($this->cachePrefix . 'feed');

        if (!$jwt) {
            try {
                $this->login();
                $jwt = Cache::get($this->cachePrefix . 'jwt');
                $feed = Cache::get($this->cachePrefix . 'feed');
            } catch (Exception $e) {
                return ['status' => false, 'message' => 'Login failed: ' . $e->getMessage(), 'data' => null];
            }
        }

        return [
            'status' => true,
            'data' => [
                'jwt' => $jwt,
                'feed' => $feed,
                'client_code' => config('services.angel.client_code', env('ANGEL_CLIENT_CODE')),
                'api_key' => config('services.angel.api_key', env('ANGEL_API_KEY')),
            ],
        ];
    }

 public function searchScrip(string $query, string $exchange = 'NSE'): array
    {
        $query = strtoupper(trim($query));
        if (strlen($query) < 2) return [];

        $client = new Client([
            'timeout' => 20,
            'verify'  => false
        ]);

        $response = $client->get(
            'https://margincalculator.angelbroking.com/OpenAPI_File/files/OpenAPIScripMaster.json'
        );

        $data = json_decode($response->getBody()->getContents(), true);
        if (empty($data)) return [];

        $results = [];
        $count = 0;

        foreach ($data as $item) {

            $exch = strtoupper($item['exch_seg'] ?? '');
            if ($exchange !== 'ALL' && $exch !== $exchange) {
                continue;
            }

            $rawSymbol = strtoupper($item['symbol'] ?? '');
            $cleanSymbol = str_replace(['-EQ', '-BE'], '', $rawSymbol);
            $name = strtoupper($item['name'] ?? '');

            if (
                str_contains($cleanSymbol, $query) ||
                str_contains($rawSymbol, $query) ||
                str_contains($name, $query)
            ) {
                $results[] = $item;
                $count++;
            }

            if ($count >= 20) break;
        }

        return $results;
    }
}