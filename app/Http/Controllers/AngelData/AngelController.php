<?php

namespace App\Http\Controllers\AngelData;

use App\Http\Controllers\Controller;
use App\Services\AngelOneService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AngelController extends Controller
{
    public function login(AngelOneService $angel): JsonResponse
    {
        try {
            $data = $angel->login();
            return response()->json([
                'status' => true,
                'message' => 'Logged in',
                'data' => [
                    'jwt' => \Cache::get('angel_jwt'),
                    'feed' => \Cache::get('angel_feed'),
                    'raw' => $data,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function history(Request $request, AngelOneService $angel): JsonResponse
    {
        $symbol = $request->query('symbol', config('services.angel.default_symbol', '99926000'));
        $interval = strtoupper($request->query('interval', 'FIFTEEN_MINUTE'));
        $from = $request->query('from');
        $to = $request->query('to');

        $res = $angel->historical($symbol, $interval, $from, $to);

        if (empty($res['status'])) {
            return response()->json($res, 400);
        }

        return response()->json([
            'status' => true,
            'message' => $res['message'] ?? 'OK',
            'data' => $res['data'] ?? [],
        ]);
    }

    public function quote(Request $request, AngelOneService $angel): JsonResponse
    {
        $single = $request->query('symbol');
        $multi = $request->query('symbols');
        $mode = $request->query('mode', 'FULL');
        $exchange = $request->query('exchange', 'NSE');

        $symbols = [];
        if (!empty($multi)) {
            $symbols = is_array($multi) ? $multi : array_filter(array_map('trim', explode(',', (string)$multi)));
        } elseif (!empty($single)) {
            $symbols = [trim((string)$single)];
        } else {
            $symbols = [config('services.angel.default_symbol', '99926000')];
        }

        $res = $angel->quote($symbols, $mode, $exchange);

        $statusCode = empty($res['status']) ? 400 : 200;
        return response()->json($res, $statusCode);
    }

    /**
     * Get Top Gainers and Losers (Derivatives Segment)
     * Endpoint: /rest/secure/angelbroking/marketData/v1/gainersLosers
     */
    public function gainersLosers(Request $request, AngelOneService $angel): JsonResponse
    {
        $input = strtoupper($request->query('datatype', 'GAINERS'));
        
        $map = [
            'GAINERS'    => 'PercPriceGainers',
            'LOSERS'     => 'PercPriceLosers',
            'OI_GAINERS' => 'PercOIGainers',
            'OI_LOSERS'  => 'PercOILosers',
        ];

        $datatype = $map[$input] ?? $input;

        $exchange = strtoupper($request->query('exchange', 'NSE'));

        $expirytype = strtoupper($request->query('expirytype', 'NEAR'));

        $res = $angel->gainersLosers($datatype, $exchange, $expirytype);

        $statusCode = empty($res['status']) ? 400 : 200;
        return response()->json($res, $statusCode);
    }
    
    
    public function getIndices(AngelOneService $angel): JsonResponse
    {
        // NSE Indices Tokens
        $nseTokens = [
            // Broad Market
            '99926000', // Nifty 50
            '99926004', // Nifty Midcap 50
            '99926009', // Nifty Bank
            '99926037', // Nifty Fin Service

            // Sectoral Indices
            '99926002', // Nifty Auto
            '99926005', // Nifty FMCG
            '99926006', // Nifty IT
            '99926007', // Nifty Media
            '99926008', // Nifty Metal
            '99926010', // Nifty Pharma
            '99926011', // Nifty Private Bank
            '99926012', // Nifty PSU Bank
            '99926013', // Nifty Realty
            '99926016', // Nifty Consumer Durables
            '99926017', // Nifty Oil & Gas
            '99926018', // Nifty Healthcare
            
            // Others often available
            '99926019', // Nifty India Consumption
            '99926020', // Nifty CPSE
            '99926021', // Nifty Infrastructure
            '99926022', // Nifty Energy
            '99926025', // Nifty Commodities
        ];
        
        // BSE Indices
        $bseTokens = [
            '99919000'  // Sensex
        ];

        try {
            $nseData = $angel->quote($nseTokens, 'FULL', 'NSE');
            $bseData = $angel->quote($bseTokens, 'FULL', 'BSE');

            $mergedFetched = [];

            if (!empty($nseData['status']) && !empty($nseData['data'])) {
                $raw = $nseData['data']['fetched'] ?? ($nseData['data'] ?? []);
                if (isset($raw['symbolToken'])) $raw = [$raw];
                $mergedFetched = array_merge($mergedFetched, $raw);
            }
            

            if (!empty($bseData['status']) && !empty($bseData['data'])) {
                $raw = $bseData['data']['fetched'] ?? ($bseData['data'] ?? []);
                if (isset($raw['symbolToken'])) $raw = [$raw];
                $mergedFetched = array_merge($mergedFetched, $raw);
            }

            return response()->json([
                'status' => true,
                'message' => 'SUCCESS',
                'data' => [
                    'fetched' => $mergedFetched,
                    'unfetched' => []
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get NIFTY 50 Top Stocks Quote Data (for Marquee)
     */
    public function nifty50Marquee(Request $request, AngelOneService $angel): JsonResponse
    {
        $nifty50Stocks = [
            '2885',  // RELIANCE
            '11536', // RELIANCE
            '1594',  // INFY
            '3045',  // SBIN
            '1660',  // HDFCBANK
            '1333',  // HINDUNILVR
            '10999', // TCS
            '317',   // AXISBANK
            '3456',  // ICICIBANK
            '11483', // LT
            '2475',  // ITC
            '3506',  // KOTAKBANK
            '3351',  // BAJFINANCE
            '4963',  // MARUTI
            '881',   // BHARTIARTL
            '2031',  // HCLTECH
        ];

        try {
            $res = $angel->quote($nifty50Stocks, 'FULL', 'NSE');

            if (empty($res['status']) || empty($res['data'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to fetch NIFTY 50 marquee data'
                ], 400);
            }

            $fetched = $res['data']['fetched'] ?? ($res['data'] ?? []);
            
            if (isset($fetched['symbolToken'])) {
                $fetched = [$fetched];
            }

            $formatted = [];

            foreach ($fetched as $item) {
                $ltp = (float) ($item['ltp'] ?? 0);
                
                $prev = (float) ($item['close'] ?? $ltp);

                if ($prev > 0) {
                    $changePercent = round((($ltp - $prev) / $prev) * 100, 2);
                } else {
                    $changePercent = 0.00;
                }

                $formatted[] = [
                    'symbol' => $item['tradingSymbol'] ?? '',
                    'ltp'    => $ltp,
                    'change' => $changePercent,
                    'trend'  => $changePercent >= 0 ? 'UP' : 'DOWN',
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'SUCCESS',
                'data' => $formatted
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch 52 Week High/Low Data for specific symbols
     */
    public function fetch52WeekHighLowData(Request $request, AngelOneService $angel): JsonResponse
    {
        $single = $request->query('symbol');
        $multi = $request->query('symbols');
        $exchange = $request->query('exchange', 'NSE');

        $symbols = [];
        if (!empty($multi)) {
            $symbols = is_array($multi) ? $multi : array_filter(array_map('trim', explode(',', (string)$multi)));
        } elseif (!empty($single)) {
            $symbols = [trim((string)$single)];
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Please provide a symbol or comma-separated symbols.'
            ], 400);
        }

        $res = $angel->quote($symbols, 'FULL', $exchange);

        if (empty($res['status']) || empty($res['data'])) {
            return response()->json([
                'status' => false,
                'message' => $res['message'] ?? 'Failed to fetch data from broker',
            ], 400);
        }

        // Robust data extraction
        $rawFetched = $res['data']['fetched'] ?? ($res['data'] ?? []);
        if (isset($rawFetched['symbolToken'])) {
            $rawFetched = [$rawFetched];
        }
        
        $formattedData = [];

        foreach ($rawFetched as $item) {
            $formattedData[] = [
                'symbolToken'   => $item['symbolToken'] ?? null,
                'tradingSymbol' => $item['tradingSymbol'] ?? null,
                'ltp'           => $item['ltp'] ?? 0,
                '52_week_high'  => $item['high52'] ?? ($item['52WeekHigh'] ?? null),
                '52_week_low'   => $item['low52'] ?? ($item['52WeekLow'] ?? null),
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $formattedData,
            'unfetched' => $res['data']['unfetched'] ?? []
        ]);
    }
    
    public function wsToken(AngelOneService $angel): JsonResponse
    {
        $res = $angel->wsToken();
        $statusCode = empty($res['status']) ? 400 : 200;
        return response()->json($res, $statusCode);
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Search Symbols and Return Quote Data
     */
public function searchSymbols(Request $request): JsonResponse
{
    $query = strtoupper(trim($request->query('query', '')));

    if (strlen($query) < 2) {
        return response()->json(['status' => true, 'data' => []]);
    }

    try {
        ini_set('memory_limit', '1024M');
        set_time_limit(60);

        $client = new \GuzzleHttp\Client([
            'timeout' => 30,
            'verify' => false
        ]);

        $res = $client->get(
            'https://margincalculator.angelbroking.com/OpenAPI_File/files/OpenAPIScripMaster.json'
        );

        $json = json_decode($res->getBody()->getContents(), true);

        // 🔴 HARD FAIL CHECK
        if (!is_array($json)) {
            return response()->json([
                'status' => false,
                'message' => 'Scrip master not loaded'
            ], 500);
        }

        $out = [];
        foreach ($json as $row) {

            if (($row['exch_seg'] ?? '') !== 'NSE') continue;

            $symbol = strtoupper($row['symbol'] ?? '');
            $clean = str_replace(['-EQ', '-BE'], '', $symbol);

            if (str_contains($clean, $query)) {
                $out[] = [
                    'symbol' => $clean,
                    'name' => $row['name'] ?? $clean,
                    'exchange' => 'NSE',
                    'token' => $row['token'] ?? '',
                    'instrument' => $row['instrumenttype'] ?? '',
                    'ltp' => '--',
                    'positive' => true
                ];
            }

            if (count($out) >= 20) break;
        }

        return response()->json([
            'status' => true,
            'data' => $out
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

}