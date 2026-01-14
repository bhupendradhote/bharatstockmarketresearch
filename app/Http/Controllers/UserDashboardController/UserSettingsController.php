<?php

namespace App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Models\ServicePlan;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    /**
     * Profile / Settings page
     */
    public function profile()
    {
        $user = auth()->user();

        // 🔹 Active subscription (only ONE possible)
        $activeSubscription = UserSubscription::with([
                'plan',
                'duration'
            ])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        // 🔹 Calculate plan info safely
        $currentPlan = $activeSubscription?->plan?->name ?? 'No Active Plan';

        $validityTill = $activeSubscription && $activeSubscription->end_date
            ? $activeSubscription->end_date->format('d M Y')
            : '-';

        $daysRemaining = $activeSubscription && $activeSubscription->end_date
            ? now()->diffInDays($activeSubscription->end_date, false)
            : null;

        if ($daysRemaining !== null && $daysRemaining < 0) {
            $daysRemaining = 0;
        }

        // 🔹 Plans for upgrade modal
        $plans = ServicePlan::with('durations.features')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('UserDashboard.settings.profile', compact(
            'user',
            'activeSubscription',
            'currentPlan',
            'validityTill',
            'daysRemaining',
            'plans'
        ));
    }
}
