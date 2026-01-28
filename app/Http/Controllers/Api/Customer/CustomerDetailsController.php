<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDetailsController extends Controller
{
    /**
     * Return authenticated customer full details with KYC & Subscription
     */
public function index(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'Unauthenticated',
        ], 401);
    }

    // Base user data
    $userData = $user->toArray();

    // KYC
    $userData['kyc'] = \App\Models\KycVerification::where('user_id', $user->id)->first();

    // Subscription
    $subscription = \App\Models\UserSubscription::where('user_id', $user->id)
        ->where('status', 'active')
        ->first();

    $userData['subscription'] = $subscription;

    // Plan
    $userData['plan'] = null;
    if ($subscription && $subscription->service_plan_id) {
        $userData['plan'] = \App\Models\ServicePlan::where(
            'id',
            $subscription->service_plan_id
        )->first();
    }

    // Tips
    $userData['tips'] = [];
    if ($subscription && $subscription->service_plan_id) {

        $tipIds = \App\Models\TipPlanAccess::where(
            'service_plan_id',
            $subscription->service_plan_id
        )->pluck('tip_id');

        $userData['tips'] = \App\Models\Tip::whereIn('id', $tipIds)
            ->with('category')
            ->get();
    }

    return response()->json([
        'status'  => true,
        'message' => 'Customer profile fetched successfully',
        'data'    => [
            'user' => $userData
        ],
    ], 200);
}



}
