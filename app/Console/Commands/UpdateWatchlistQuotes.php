<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WatchlistScript;
use App\Services\AngelOneService;
use Illuminate\Support\Facades\Log;

class UpdateWatchlistQuotes extends Command
{
    protected $signature = 'watchlists:update-quotes';
    protected $description = 'Continuously updates watchlist script prices every 3 seconds';

    public function handle(AngelOneService $angel)
    {
        $this->info("📈 Watchlist Price Update Service Started (Ctrl+C to stop)");

        while (true) {
            $start = microtime(true);

            try {
                $this->updatePrices($angel);
            } catch (\Throwable $e) {
                Log::error('Watchlist quote updater error', [
                    'error' => $e->getMessage()
                ]);
                $this->error($e->getMessage());
            }

            $executionTime = microtime(true) - $start;
            $sleepTime = max(0, 3 - $executionTime);

            if ($sleepTime > 0) {
                usleep((int) ($sleepTime * 1_000_000)); // microseconds
            }
        }
    }

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

            // Avoid unnecessary writes
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
        }

        $this->line('✔ Watchlist updated @ ' . now()->format('H:i:s'));
    }
}
