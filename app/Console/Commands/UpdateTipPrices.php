<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Pool;

class UpdateTipPrices extends Command
{

    protected $signature = 'tips:update-prices';

    protected $description = 'Updates CMP Price of active tips every 10 seconds using external API';

    public function handle()
    {
        $this->info("Starting Price Update Service... (Press Ctrl+C to stop)");

        // Run infinitely
        while (true) {
            $start = microtime(true);

            $this->updatePrices();

            $executionTime = microtime(true) - $start;
            $this->info("Batch updated in " . round($executionTime, 2) . " seconds.");

            $sleepTime = max(0, 5 - $executionTime);
            
            if ($sleepTime > 0) {
                $this->comment("Sleeping for " . round($sleepTime, 2) . " seconds...");
                sleep((int)$sleepTime);
            }
        }
    }

    protected function updatePrices()
    {
        $activeTips = Tip::where('status', 'active')
            ->whereNotNull('symbol_token')
            ->where('symbol_token', '!=', '')
            ->get();

        if ($activeTips->isEmpty()) {
            return;
        }

        $responses = Http::pool(function (Pool $pool) use ($activeTips) {
            foreach ($activeTips as $tip) {
                $pool->as($tip->id)->get('https://bharatstockmarketresearch.com/api/angel/quote', [
                    'symbol'   => $tip->symbol_token,
                    'exchange' => $tip->exchange
                ]);
            }
        });

        foreach ($responses as $tipId => $response) {
            $tip = $activeTips->find($tipId);

            if ($response->ok()) {
                $json = $response->json();

                if (isset($json['status']) && $json['status'] === true && !empty($json['data']['fetched'])) {
                    
                    $marketData = $json['data']['fetched'][0];
                    $newLtp = $marketData['ltp'] ?? null;

                    if ($newLtp) {
                        if ($tip->cmp_price != $newLtp) {
                            $tip->cmp_price = $newLtp;
                            $tip->save();
                            $this->info("Updated {$tip->stock_name} (ID: $tipId) -> CMP: $newLtp");
                        }
                    }
                } else {
                    $this->error("API Error for {$tip->stock_name}: Invalid Response Data");
                }
            } else {
                $this->error("Connection Failed for {$tip->stock_name} (ID: $tipId)");
            }
        }
    }
}
