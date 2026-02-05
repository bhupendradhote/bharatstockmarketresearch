<?php


namespace App\Http\Controllers;

use App\Models\ServicePlan;
use App\Models\ServicePlanDuration;
use App\Models\User;
use App\Models\Invoice;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Models\KycVerification;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Errors\SignatureVerificationError;

       use App\Models\Coupon;

class SubscriptionController extends Controller{


        public function confirm(Request $request)
        {
            $user = auth()->user();

            /* ===============================
            * 🔹 KYC CHECK (SOURCE OF TRUTH)
            * =============================== */
            $latestKyc = KycVerification::where('user_id', $user->id)
                ->latest()
                ->first();

            $kycStatus = $latestKyc->status ?? 'none';

            $isKycCompleted = in_array($kycStatus, [
                'approved',
                'completed',
                'success'
            ]);

            /* ===============================
            * 🔹 ALL ACTIVE PLANS
            * =============================== */
            $plans = ServicePlan::with('durations')
                ->where('status', 1)
                ->orderBy('sort_order')
                ->get();

            if ($plans->isEmpty()) {
                abort(404, 'No plans available');
            }

            /* ===============================
            * 🔹 SELECTED PLAN / DURATION
            * =============================== */
            $selectedPlan = $plans->firstWhere('id', $request->plan)
                ?? $plans->first();

            $selectedDuration = $selectedPlan->durations[$request->duration ?? 0]
                ?? $selectedPlan->durations->first();

            return view('subscription.confirm', [
                'plans'            => $plans,
                'selectedPlan'     => $selectedPlan,
                'selectedDuration' => $selectedDuration,
                'kycStatus'        => $kycStatus,
                'isKycCompleted'   => $isKycCompleted,
            ]);
        }

        // Apply coupon code on selected plan...


        public function applyCoupon(Request $request)
        {
            $user = auth()->user();
            
            // 📝 LOG: Log the initial attempt
            Log::info('Coupon Application Attempt', [
                'user_id'     => $user->id ?? 'Guest',
                'coupon_code' => $request->coupon_code,
                'duration_id' => $request->duration_id
            ]);

            $request->validate([
                'coupon_code' => 'required|string',
                'duration_id' => 'required|exists:service_plan_durations,id'
            ]);

            // Fetch the plan duration details
            $duration = DB::table('service_plan_durations')->where('id', $request->duration_id)->first();
            
            // Find the coupon in the database using your Model Scopes
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))
                ->active()      // Scope from your Model
                ->notExpired()  // Scope from your Model
                ->first();

            // ❌ REJECTION: Coupon doesn't exist, is inactive, or expired
            if (!$coupon) {
                Log::notice('Coupon Rejected: Invalid or Expired', [
                    'user_id' => $user->id,
                    'code_entered' => $request->coupon_code
                ]);
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid or expired coupon code.'
                ]);
            }

            // ❌ REJECTION: Global usage limit reached
            if ($coupon->isGlobalLimitReached()) {
                Log::notice('Coupon Rejected: Limit Reached', ['coupon_id' => $coupon->id]);
                return response()->json([
                    'success' => false, 
                    'message' => 'This coupon code has reached its maximum usage limit.'
                ]);
            }

            // ❌ REJECTION: Minimum amount requirement not met
            if (!$coupon->isApplicableOn($duration->price)) {
                return response()->json([
                    'success' => false, 
                    'message' => 'This coupon is only applicable for orders above ₹' . $coupon->min_amount
                ]);
            }

            // ✅ SUCCESS: Calculate discount using Model Helper
            $discount = $coupon->calculateDiscount($duration->price);
            $newTotal = max(0, $duration->price - $discount);

            Log::info('Coupon Applied Successfully', [
                'user_id'        => $user->id,
                'coupon_code'    => $coupon->code,
                'original_price' => $duration->price,
                'discount'       => $discount,
                'new_total'      => $newTotal
            ]);

            return response()->json([
                'success'   => true,
                'discount'  => $discount,
                'new_total' => number_format($newTotal, 2),
                'message'   => 'Coupon "' . $coupon->code . '" applied successfully!'
            ]);
        }


            private function validateCouponUsage($coupon, $userId)
    {
        $alreadyUsed = \App\Models\CouponUsage::where('coupon_id', $coupon->id)
            ->where('user_id', $userId)
            ->sum('times_used');

        if ($alreadyUsed >= $coupon->per_user_limit) {
            return 'You already used this coupon maximum times';
        }

        if ($coupon->used_global >= $coupon->global_limit) {
            return 'Coupon usage limit reached';
        }

        return null; // ✅ OK
    }
        
            public function initiateRazorpay(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:service_plans,id',
            'duration_id' => 'required|exists:service_plan_durations,id',
            'coupon_code' => 'nullable|string' // Added validation for coupon
        ]);

        // ✅ Authenticated user
        $user = Auth::user();

        // ✅ Selected plan
        $plan = DB::table('service_plans')
            ->where('id', $request->plan_id)
            ->first();

        // ✅ Selected duration (belongs to plan)
        $duration = DB::table('service_plan_durations')
            ->where('id', $request->duration_id)
            ->where('service_plan_id', $plan->id)
            ->first();

        if (!$plan || !$duration) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid plan or duration'
            ]);
        }

        // ✅ Default Amount (Original Price)
        $finalPrice = $duration->price;
        if ($request->filled('coupon_code')) {

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
            ->active()
            ->notExpired()
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon'
            ], 422);
        }

        $error = $this->validateCouponUsage($coupon, auth()->id());

        if ($error) {
            return response()->json([
                'success' => false,
                'message' => $error
            ], 422);
        }

     }


        // ✅ Apply Coupon Logic (if provided)
        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))
                ->active()
                ->notExpired()
                ->first();

            if ($coupon && !$coupon->isGlobalLimitReached() && $coupon->isApplicableOn($duration->price)) {
                $discount = $coupon->calculateDiscount($duration->price);
                $finalPrice = max(0, $duration->price - $discount);
                
                Log::info('Razorpay Coupon Applied', [
                    'user_id' => $user->id,
                    'coupon' => $coupon->code,
                    'discount' => $discount,
                    'final_price' => $finalPrice
                ]);
            } else {
                // Optional: You can return an error here if you want to force valid coupons
                // But usually, it's safer to proceed with original price if verification fails at this stage
                Log::warning('Razorpay Coupon Invalid at Initiation', ['code' => $request->coupon_code]);
            }
        }

        // ✅ Amount from DB (₹ → paise)
        $amountInPaise = (int) (round($finalPrice, 2) * 100);

        // ✅ BACKEND LOG
        Log::info('Razorpay Initiate', [
            'user_id' => $user->id,
            'plan_name' => $plan->name,
            'amount_rupees' => $finalPrice,
            'coupon_used' => $request->coupon_code ?? 'None'
        ]);

        // ✅ Razorpay
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $order = $api->order->create([
                'receipt' => 'rcpt_' . uniqid(),
                'amount' => $amountInPaise,
                'currency' => 'INR'
            ]);

            return response()->json([
                'success' => true,
                'key' => config('services.razorpay.key'),
                'amount' => $amountInPaise,
                'order_id' => $order['id'],
                'description' => $plan->name . ' - ' . $duration->duration . ($request->coupon_code ? ' (Coupon Applied)' : ''),
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'contact' => $user->phone ?? '9999999999'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment initiation failed.']);
        }
    }

      

        public function verifyRazorpay(Request $request)
        {
            $request->validate([
                'razorpay_order_id'    => 'required',
                'razorpay_payment_id' => 'required',
                'razorpay_signature'  => 'required',
                'plan_id'              => 'required|exists:service_plans,id',
                'duration_id'          => 'required|exists:service_plan_durations,id',
                'coupon_code'          => 'nullable|string',
            ]);

            $user = Auth::user();

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );



            

            // 🔐 Verify Razorpay signature
            try {
                $api->utility->verifyPaymentSignature([
                    'razorpay_order_id'    => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature'  => $request->razorpay_signature,
                ]);
            } catch (SignatureVerificationError $e) {
                return response()->json(['success' => false, 'message' => 'Payment verification failed'], 422);
            }

            // 📦 Fetch duration row
            $durationRow = DB::table('service_plan_durations')->where('id', $request->duration_id)->first();

            if (!$durationRow) {
                return response()->json(['success' => false, 'message' => 'Invalid duration'], 422);
            }

            // ✅ STEP 1: CALCULATE END DATE DYNAMICALLY
            $startDate = now();
            $endDate = now();

            // extract number from string like "1 Month" or "3 Months"
            $durationValue = (int) filter_var($durationRow->duration, FILTER_SANITIZE_NUMBER_INT);
            
            if (str_contains(strtolower($durationRow->duration), 'month')) {
                $endDate = $startDate->copy()->addMonths($durationValue);
            } elseif (str_contains(strtolower($durationRow->duration), 'day')) {
                $endDate = $startDate->copy()->addDays($durationValue);
            } else {
                // Fallback to duration_days column if string parsing fails
                $days = $durationRow->duration_days ?? 30; 
                $endDate = $startDate->copy()->addDays((int)$days);
            }

            // ✅ STEP 2: CALCULATE FINAL PRICE (HANDLING COUPON)
            $finalAmount = $durationRow->price;
            $appliedCoupon = null;

            if ($request->filled('coupon_code')) {
                $appliedCoupon = Coupon::where('code', strtoupper($request->coupon_code))
                    ->active()
                    ->notExpired()
                    ->first();

                if ($appliedCoupon && $appliedCoupon->isApplicableOn($durationRow->price)) {
                    $discount = $appliedCoupon->calculateDiscount($durationRow->price);
                    $finalAmount = max(0, $durationRow->price - $discount);
                }
            }

            DB::beginTransaction();

            try {
                /**
                 * ✅ STEP 3: EXPIRE OLD ACTIVE SUBSCRIPTIONS
                 */
                UserSubscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->update([
                        'status'   => 'expired',
                        'end_date' => now(),
                    ]);

                /**
                 * ✅ STEP 4: CREATE NEW ACTIVE SUBSCRIPTION
                 */
                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'service_plan_id' => $request->plan_id,
                    'service_plan_duration_id' => $request->duration_id,
                    'start_date' => $startDate,
                    'end_date'   => $endDate, // Corrected date
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'amount' => $finalAmount,
                    'currency' => 'INR',
                    'payment_gateway' => 'razorpay',
                    'payment_reference' => $request->razorpay_payment_id,
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ]);

                /**
                 * ✅ STEP 5: GENERATE INVOICE
                 */
                $lastInvoice = Invoice::lockForUpdate()->orderByDesc('id')->first();
                $lastNumber = ($lastInvoice && $lastInvoice->invoice_number) ? (int) substr($lastInvoice->invoice_number, 3) : 0;
                $invoiceNumber = 'INV' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

                    $invoice = Invoice::create([
                    'user_id' => $user->id,
                    'user_subscription_id' => $subscription->id,
                    'invoice_number' => $invoiceNumber,
                    'amount' => $finalAmount,
                    'currency' => 'INR',
                    'payment_gateway' => 'razorpay',
                    'payment_reference' => $request->razorpay_payment_id,
                    'invoice_date' => now(),
                    'service_start_date' => $startDate,
                    'service_end_date' => $endDate,
                ]);

                /**
                 * ✅ STEP 6: RECORD COUPON USAGE
                 */


                if ($appliedCoupon) {

                    $appliedCoupon->increment('used_global');

                    $usage = \App\Models\CouponUsage::where('coupon_id', $appliedCoupon->id)
                        ->where('user_id', $user->id)
                        ->first();   // 👈 important (not get)

                    if ($usage) {

                        $usage->increment('times_used');
                        $usage->update([
                            'invoice_id' => $invoice->id
                        ]);

                    } else {

                        \App\Models\CouponUsage::create([
                            'coupon_id'  => $appliedCoupon->id,
                            'user_id'    => $user->id,
                            'invoice_id' => $invoice->id,
                            'times_used' => 1
                        ]);
                    }
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Razorpay Verify Failed', ['error' => $e->getMessage()]);
                return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment verified & subscription activated'
            ]);
        }

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