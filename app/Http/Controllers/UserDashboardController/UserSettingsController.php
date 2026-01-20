<?php

namespace App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Models\ServicePlan;
use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class UserSettingsController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        $activeSubscription = UserSubscription::with(['plan', 'duration'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        $currentPlan = $activeSubscription?->plan?->name ?? 'No Active Plan';
        $validityTill = $activeSubscription?->end_date?->format('d M Y') ?? '-';
        $daysRemaining = $activeSubscription?->end_date ? max(0, now()->diffInDays($activeSubscription->end_date, false)) : null;

        $latestKyc = KycVerification::where('user_id', $user->id)->latest()->first();
        $kycStatus = $latestKyc->status ?? 'none';
        $isKycCompleted = in_array($kycStatus, ['approved', 'completed', 'success']);

        $plans = ServicePlan::with('durations.features')->where('status', 1)->orderBy('sort_order')->get();

        return view('UserDashboard.settings.profile', compact(
            'user', 'activeSubscription', 'currentPlan', 'validityTill', 'daysRemaining', 'plans', 'kycStatus', 'isKycCompleted'
        ));
    }

    public function edit() {
        $user = auth()->user();
        return view('UserDashboard.settings.edit-profile', compact('user'));
    }

    public function updateGeneralProfile(Request $request)
    {
        $user = auth()->user();
        
        // 1. Validate the new fields
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'dob'     => 'nullable|date', // Added Date of Birth
            'address' => 'nullable|string|max:500', // Added Address
            'city'    => 'nullable|string|max:100',
            'state'   => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        // 2. Update user record
        $user->update($data);

        // 3. Handle Profile Image
        if ($request->hasFile('profile_image')) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        return back()->with('success', 'Profile details updated successfully!');
    }
   
    public function sendOtp(Request $request)
    {
        Log::info('OTP Request Received', [
            'user_id' => auth()->id(),
            'payload' => $request->all()
        ]);

        $request->validate([
            'type'  => 'required|in:email,phone',
            'value' => 'required',
        ]);

        $otp   = random_int(100000, 999999);
        $type  = $request->type;
        $value = $request->value;
        $user  = auth()->user();

        Log::info('OTP Generated', [
            'type'  => $type,
            'value' => $value,
            'otp'   => $otp, // ❗ remove in production
        ]);

        // ✅ Store OTP in session
        Session::put("otp_verify_{$type}", [
            'otp'        => $otp,
            'value'      => $value,
            'expires_at' => now()->addMinutes(10),
        ]);

        Log::info('OTP Stored in Session', [
            'session_key' => "otp_verify_{$type}",
            'session_data' => Session::get("otp_verify_{$type}")
        ]);

        // ================= EMAIL OTP =================
        if ($type === 'email') {
            try {

                Log::info('Attempting to send OTP email', [
                    'to' => $value,
                    'from' => env('MAIL_FROM_ADDRESS')
                ]);

                Mail::send([], [], function ($message) use ($value, $otp, $user) {
                    $message->to($value)
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->subject('Email Verification OTP')
                        ->html("
                            <div style='font-family:Arial;padding:20px;border:1px solid #eee;border-radius:10px;'>
                                <h2>Hello " . ($user->name ?? 'User') . ",</h2>
                                <p>You are requesting to update your email address.</p>
                                <p>Your Verification OTP is:</p>
                                <h1 style='letter-spacing:4px;color:#2563eb;'>{$otp}</h1>
                                <p>This OTP is valid for 10 minutes.</p>
                            </div>
                        ");
                });

                Log::info('OTP Email Sent Successfully', [
                    'email' => $value
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent to your email successfully.'
                ]);

            } catch (\Exception $e) {

                Log::error('OTP Email Failed', [
                    'email' => $value,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Mail error: ' . $e->getMessage()
                ], 500);
            }
        }

        // ================= PHONE OTP =================
        Log::info('Attempting to send OTP SMS', [
            'phone' => $value
        ]);

        if ($this->sendOtpSms($value, $otp)) {

            Log::info('OTP SMS Sent Successfully', [
                'phone' => $value
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent to your mobile successfully.'
            ]);
        }

        Log::error('OTP SMS Failed', [
            'phone' => $value
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to send SMS. Please try again.'
        ], 500);
    }  

        public function verifyAndUpdate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,phone',
            'otp' => 'required|numeric'
        ]);

        $type = $request->type;
        $sessionData = Session::get("otp_verify_{$type}");

        if (!$sessionData || now()->gt($sessionData['expires_at'])) {
            return response()->json(['success' => false, 'message' => 'OTP expired. Please try again.'], 422);
        }

        if ($request->otp != $sessionData['otp']) {
            return response()->json(['success' => false, 'message' => 'The OTP you entered is incorrect.'], 422);
        }

        $user = auth()->user();
        $newValue = $sessionData['value'];

        // --- FIX STARTS HERE: Check for duplicate entry before saving ---
        $exists = \App\Models\User::where($type, $newValue)
                    ->where('id', '!=', $user->id)
                    ->exists();

        if ($exists) {
            return response()->json([
                'success' => false, 
                'message' => "This " . $type . " is already registered to another account."
            ], 422);
        }
        // --- FIX ENDS HERE ---

        if ($type === 'email') {
            $user->email = $newValue;
        } else {
            $user->phone = $newValue;
        }
        
        $user->save();

        Session::forget("otp_verify_{$type}");

        return response()->json(['success' => true, 'message' => ucfirst($type) . ' updated successfully!']);
    }

    private function sendOtpSms($phone, $otp)
    {
        // Using your specific message template
        $message = "Hello, Your https://bharatstockmarketresearch.com registration OTP is {$otp}. Use this code to complete your sign-up process. Regards, Bharat Stock Market Research.";

        $response = Http::get(config('services.sms.base_url'), [
            'user'      => config('services.sms.user'),
            'key'       => config('services.sms.key'),
            'mobile'    => config('services.sms.country') . $phone,
            'message'   => $message,
            'senderid'  => config('services.sms.sender'),
            'accusage'  => 1,
            'entityid'  => config('services.sms.entity_id'),
            'tempid'    => config('services.sms.template_id'),
        ]);

        return $response->successful();
    }
}