<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use App\Events\PlanExpiringEvent;
use Carbon\Carbon;

class CheckPlanExpiration extends Command
{
    protected $signature = 'plan:check-expiration';
    protected $description = 'Check for plans expiring in 3, 2, or 1 days and notify users via Pusher';

    public function handle()
    {
        $daysToNotify = [0, 1, 2,3];

        foreach ($daysToNotify as $days) {
            $targetDate = Carbon::now()->addDays($days)->toDateString();

            $subscriptions = UserSubscription::where('status', 'active')
                ->whereDate('end_date', $targetDate)
                ->get();

            foreach ($subscriptions as $sub) {
                event(new PlanExpiringEvent($sub->user_id, $days));
            }
        }

        $this->info('Expiration checks completed and notifications sent.');
    }
}