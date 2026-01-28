<?php

namespace App\Http\Controllers\AngelData;

use App\Http\Controllers\Controller;
use App\Services\AngelOneService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

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
     * Fetch 52 Week High/Low Data for specific symbols
     */
    public function fetch52WeekHighLowData(Request $request, AngelOneService $angel): JsonResponse
    {
        $single = $request->query('symbol');
        $multi = $request->query('symbols');
        $exchange = $request->query('exchange', 'NSE');

        // Determine symbols list
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

        // 52-week data is available in 'FULL' mode
        $res = $angel->quote($symbols, 'FULL', $exchange);

        if (empty($res['status']) || empty($res['data'])) {
            return response()->json([
                'status' => false,
                'message' => $res['message'] ?? 'Failed to fetch data from broker',
            ], 400);
        }

        // Extract specifically the 52-week data from the response
        $rawFetched = $res['data']['fetched'] ?? [];
        $formattedData = [];

        foreach ($rawFetched as $item) {
            $formattedData[] = [
                'symbolToken'   => $item['symbolToken'] ?? null,
                'tradingSymbol' => $item['tradingSymbol'] ?? null,
                'ltp'           => $item['ltp'] ?? 0,
                // Angel One API usually returns these as 'high52' and 'low52'
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
}