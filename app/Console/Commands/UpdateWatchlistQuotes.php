<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WatchlistScript;
use App\Services\AngelOneService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UpdateWatchlistQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watchlists:update-quotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Continuously updates watchlist script prices and repairs missing tokens every 3 seconds';

    /**
     * Execute the console command.
     */
    public function handle(AngelOneService $angel)
    {
        $this->info("📈 Watchlist Price Update Service Started (Ctrl+C to stop)");

        while (true) {
            $start = microtime(true);

            try {
                // Step 1: Repair scripts that have no Token (Self-Healing)
                $this->repairMissingTokens();

                // Step 2: Update Prices for valid scripts
                $this->updatePrices($angel);

            } catch (\Throwable $e) {
                Log::error('Watchlist quote updater error', [
                    'error' => $e->getMessage()
                ]);
                $this->error("Error: " . $e->getMessage());
            }

            // Sleep logic to maintain roughly a 3-second cycle
            $executionTime = microtime(true) - $start;
            $sleepTime = max(0, 3 - $executionTime);

            if ($sleepTime > 0) {
                usleep((int) ($sleepTime * 1_000_000)); // Convert to microseconds
            }
        }
    }

    /**
     * Finds scripts with missing tokens and fetches them using the public API
     */
    protected function repairMissingTokens()
    {
        // Find scripts where token is NULL or empty
        $brokenScripts = WatchlistScript::whereNull('token')
            ->orWhere('token', '')
            ->get();

        if ($brokenScripts->isEmpty()) {
            return;
        }

        $this->comment("🔧 Found " . $brokenScripts->count() . " scripts without tokens. Repairing...");

        foreach ($brokenScripts as $script) {
            try {
                // Use your public API to search for the token
                $response = Http::get('https://bharatstockmarketresearch.com/api/angel/search', [
                    'query' => $script->symbol
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    
                    // Handle different response structures based on your API
                    $results = $json['data']['fetched'] ?? $json['data'] ?? [];

                    // Try to find exact match
                    $found = null;
                    if (is_array($results)) {
                        foreach ($results as $res) {
                            // Check both symbol and tradingSymbol keys
                            $apiSymbol = $res['symbol'] ?? $res['tradingSymbol'] ?? '';
                            if (strtoupper($apiSymbol) == strtoupper($script->symbol)) {
                                $found = $res;
                                break;
                            }
                        }
                        // Fallback: take the first result if no exact match
                        if (!$found && count($results) > 0) {
                            $found = $results[0];
                        }
                    }

                    // Update the DB if token found
                    $token = $found['token'] ?? $found['symbolToken'] ?? null;
                    
                    if ($token) {
                        $script->update(['token' => $token]);
                        $this->info("✅ Repaired token for {$script->symbol}: " . $token);
                    } else {
                        $this->warn("⚠️ Token not found in API for {$script->symbol}");
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error repairing {$script->symbol}: " . $e->getMessage());
            }
        }
    }

    /**
     * Fetches quotes for valid scripts and updates the database
     */
    protected function updatePrices(AngelOneService $angel)
    {
        /* ===============================
           1️⃣ FETCH SCRIPTS WITH TOKENS
        =============================== */
        $scripts = WatchlistScript::whereNotNull('token')
            ->where('token', '!=', '')
            ->get();

        if ($scripts->isEmpty()) {
            return;
        }

        $tokens = $scripts->pluck('token')->unique()->values()->toArray();

        /* ===============================
           2️⃣ CALL ANGEL QUOTE API
        =============================== */
        $response = $angel->quote($tokens, 'FULL', 'NSE');

        if (empty($response['status']) || empty($response['data'])) {
            return;
        }

        $fetched = $response['data']['fetched'] ?? $response['data'];

        // Normalize if single object returned
        if (isset($fetched['symbolToken'])) {
            $fetched = [$fetched];
        }

        if (!is_array($fetched)) {
            return;
        }

        /* ===============================
           3️⃣ BUILD TOKEN → QUOTE MAP
        =============================== */
        $quoteMap = [];
        foreach ($fetched as $q) {
            if (!empty($q['symbolToken'])) {
                $quoteMap[(string)$q['symbolToken']] = $q;
            }
        }

        /* ===============================
           4️⃣ UPDATE DATABASE
        =============================== */
        $updatedCount = 0;

        foreach ($scripts as $script) {
            if (!isset($quoteMap[$script->token])) {
                continue;
            }

            $q = $quoteMap[$script->token];

            $ltp    = (float) ($q['ltp'] ?? 0);
            $change = (float) ($q['netChange'] ?? 0);

            // Percent change fallback calculation
            if (isset($q['percentChange']) && $q['percentChange'] !== null) {
                $percent = (float) $q['percentChange'];
            } else {
                $prevClose = $ltp - $change;
                $percent = $prevClose > 0 ? ($change / $prevClose) * 100 : 0;
            }

            // Avoid unnecessary DB writes if values haven't changed
            if (
                (float)$script->ltp === round($ltp, 2) &&
                (float)$script->net_change === round($change, 2)
            ) {
                continue;
            }

            $script->update([
                'ltp'            => round($ltp, 2),
                'net_change'     => round($change, 2),
                'percent_change' => round($percent, 2),
                'is_positive'    => $change >= 0 ? 1 : 0,
            ]);
            
            $updatedCount++;
        }

        if ($updatedCount > 0) {
            $this->line('✔ Updated ' . $updatedCount . ' scripts @ ' . now()->format('H:i:s'));
        }
    }
}