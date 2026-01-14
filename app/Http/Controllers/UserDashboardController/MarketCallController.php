<?php

namespace App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use App\Models\TipCategory;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MarketCallController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $activeSubscription = null;
        $userId = $user ? $user->id : 'Guest';

        // Log 1: Entry Point & User Info
        Log::info("--- MarketCall Access Start ---");
        Log::info("MarketCallController: User ID = $userId, Access Time = $now");

        if ($user) {
            $activeSubscription = UserSubscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>', $now)
                ->first();

            // Log 2: Subscription Data
            if ($activeSubscription) {
                $daysLeft = (int) $now->diffInDays($activeSubscription->end_date, false);
                Log::info("Subscription Status: ACTIVE", [
                    'user_id' => $user->id,
                    'plan_id' => $activeSubscription->service_plan_id,
                    'end_date' => $activeSubscription->end_date,
                    'days_left' => $daysLeft
                ]);
                
                // Note: Expiry logic removed as per request (handled globally now)
            } else {
                Log::warning("Subscription Status: INACTIVE or NONE for User ID: {$user->id}");
            }
        }

        // Log 3: Categories Data
        $categories = TipCategory::orderBy('name')->get();
        Log::info("Categories Loaded: Count = " . $categories->count(), [
            'category_names' => $categories->pluck('name')->toArray()
        ]);

        // Log 4: Market Calls & Highlights Data
        $baseQuery = Tip::with(['category', 'planAccess.plan', 'planAccess.duration'])
            ->whereIn('status', ['active', 'Active']);

        $highlights = (clone $baseQuery)->latest()->take(4)->get();
        $marketCalls = $baseQuery->latest()->get();

        Log::info("Market Data Loaded", [
            'highlights_count' => $highlights->count(),
            'total_market_calls' => $marketCalls->count(),
            'first_call_stock' => $marketCalls->first() ? $marketCalls->first()->stock_name : 'No data'
        ]);

        Log::info("--- MarketCall Access End ---");

        return view('UserDashboard.marketCall.marketCall', compact(
            'highlights', 
            'marketCalls', 
            'categories', 
            'activeSubscription'
        ));
    }
}