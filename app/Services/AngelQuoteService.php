<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AngelQuoteService
{
    public function fetchQuotes(array $tokens)
    {
        if (empty($tokens)) {
            return [];
        }

        try {
            $response = Http::timeout(10)->post(
                config('app.url') . '/api/angel/quote',
                [
                    'exchange' => 'NSE',
                    'tokens'   => $tokens,
                ]
            );

            if (!$response->successful()) {
                Log::error('Angel quote API failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return [];
            }

            return $response->json('data.fetched') ?? [];

        } catch (\Throwable $e) {
            Log::error('Angel quote exception', [
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
