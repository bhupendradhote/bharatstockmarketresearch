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


        public function initiateRazorpay(Request $request)
        {
            $request->validate([
                'plan_id' => 'required|exists:service_plans,id',
                'duration_id' => 'required|exists:service_plan_durations,id',
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

            // ✅ Amount from DB (₹ → paise)
            $amount = (int) ($duration->price * 100);

            // ✅ BACKEND LOG (for debug)
            Log::info('Razorpay Initiate', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'duration_id' => $duration->id,
                'duration' => $duration->duration,
                'amount_rupees' => $duration->price
            ]);

            // ✅ Razorpay
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $order = $api->order->create([
                'receipt' => 'test_' . uniqid(),
                'amount' => $amount,
                'currency' => 'INR'
            ]);

            return response()->json([
                'success' => true,
                'key' => config('services.razorpay.key'),
                'amount' => $amount,
                'order_id' => $order['id'],
                'description' => $plan->name . ' - ' . $duration->duration,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'contact' => $user->phone ?? '9999999999'
                ]
            ]);
        }


        public function verifyRazorpay(Request $request)
        {
            $request->validate([
                'razorpay_order_id'    => 'required',
                'razorpay_payment_id' => 'required',
                'razorpay_signature'  => 'required',
                'plan_id'              => 'required|exists:service_plans,id',
                'duration_id'          => 'required|exists:service_plan_durations,id',
            ]);

            $user = Auth::user();

            // 🧾 LOG: Verify started
            Log::info('Razorpay Verify Started', [
                'user_id' => $user->id,
                'email' => $user->email,
                'plan_id' => $request->plan_id,
                'duration_id' => $request->duration_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

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

                Log::warning('Razorpay Signature Verification Failed', [
                    'user_id' => $user->id,
                    'order_id' => $request->razorpay_order_id,
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed'
                ], 422);
            }

            // 📦 Fetch duration
            $duration = DB::table('service_plan_durations')
                ->where('id', $request->duration_id)
                ->first();

            if (!$duration) {

                Log::warning('Invalid Duration in Razorpay Verify', [
                    'user_id' => $user->id,
                    'duration_id' => $request->duration_id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid duration'
                ], 422);
            }

            $startDate = now();
            // $endDate   = now()->addMonths((int) $duration->duration_months);
            $endDate = now()->addDays((int) $duration->duration_days);


            DB::beginTransaction();

            try {

                /**
                 * ✅ STEP 1: EXPIRE OLD ACTIVE SUBSCRIPTIONS
                 */
                $expiredCount = UserSubscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->update([
                        'status'   => 'expired',
                        'end_date' => now(),
                    ]);

                Log::info('Old Subscriptions Expired', [
                    'user_id' => $user->id,
                    'expired_count' => $expiredCount,
                ]);

                /**
                 * ✅ STEP 2: CREATE NEW ACTIVE SUBSCRIPTION
                 */
                $subscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'service_plan_id' => $request->plan_id,
                    'service_plan_duration_id' => $request->duration_id,
                    'start_date' => $startDate,
                    'end_date'   => $endDate,
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'amount' => $duration->price,
                    'currency' => 'INR',
                    'payment_gateway' => 'razorpay',
                    'payment_reference' => $request->razorpay_payment_id,
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ]);

                Log::info('New Subscription Created', [
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'plan_id' => $request->plan_id,
                    'duration_id' => $request->duration_id,
                    'amount' => $duration->price,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);

            
          /**
             * ✅ STEP 3: GENERATE INVOICE
             */

            // 🔹 Get last invoice number (FOR UPDATE = race condition safe)
            $lastInvoice = Invoice::lockForUpdate()
                ->orderByDesc('id')
                ->first();

            $lastNumber = 0;

            if ($lastInvoice && $lastInvoice->invoice_number) {
                // INV000123 → 123
                $lastNumber = (int) substr($lastInvoice->invoice_number, 3);
            }

            // 🔹 Next invoice number
            $nextNumber = $lastNumber + 1;
            $invoiceNumber = 'INV' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // 🔹 Create invoice WITH invoice_number
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'user_subscription_id' => $subscription->id,
                'invoice_number' => $invoiceNumber,
                'amount' => $duration->price,
                'currency' => 'INR',
                'payment_gateway' => 'razorpay',
                'payment_reference' => $request->razorpay_payment_id,
                'invoice_date' => now(),
                'service_start_date' => $startDate,
                'service_end_date' => $endDate,
            ]);

            Log::info('Invoice Generated', [
                'user_id' => $user->id,
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoiceNumber,
                'subscription_id' => $subscription->id,
                'amount' => $invoice->amount,
            ]);


                DB::commit();

            } catch (\Exception $e) {

                DB::rollBack();

                Log::error('Razorpay Verify Failed (Exception)', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong'
                ], 500);
            }

            Log::info('Razorpay Verify Completed Successfully', [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'invoice_id' => $invoice->id ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified, old plan expired & new subscription activated'
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