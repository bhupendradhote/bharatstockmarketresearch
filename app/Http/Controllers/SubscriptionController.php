<?php


namespace App\Http\Controllers;

use App\Models\ServicePlan;
use App\Models\ServicePlanDuration;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller{

public function confirm(Request $request)
{
    $plan = ServicePlan::findOrFail($request->plan);
    $duration = $plan->durations[$request->duration];

    return view('subscription.confirm', compact('plan', 'duration'));
}

// public function pay(Request $request)
// {
//     // Assume payment success (dummy)

//     $duration = ServicePlanDuration::findOrFail($request->duration_id);

//     UserSubscription::create([
//         'user_id' => auth()->id(),
//         'service_plan_id' => $duration->service_plan_id,
//         'service_plan_duration_id' => $duration->id,
//         'start_date' => now(),
//         'end_date' => now()->addDays($duration->duration_days),
//         'status' => 'active',
//     ]);

//     return redirect()->route('subscription.success');
// }

public function pay(Request $request)
{
    $duration = ServicePlanDuration::findOrFail($request->duration_id);

    $startDate = now();

    // 🔴 STEP 1: Cancel existing active subscription (IF ANY)
    UserSubscription::where('user_id', auth()->id())
        ->where('status', 'active')
        ->update([
            'status' => 'cancelled',
            'end_date' => $startDate,
        ]);

    // 🔵 STEP 2: Calculate end date for new subscription
    if ($duration->duration_days) {
        $endDate = $startDate->copy()->addDays($duration->duration_days);
    } else {
        // Lifetime plan
        $endDate = null;
    }

    // 🟢 STEP 3: Create new subscription
    UserSubscription::create([
        'user_id' => auth()->id(),
        'service_plan_id' => $duration->service_plan_id,
        'service_plan_duration_id' => $duration->id,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'status' => 'active',
        'payment_reference' => 'DUMMY_' . uniqid(),
    ]);

    return redirect()->route('subscription.success');
}


}