<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * ---------------------------------------------------------
     * STEP 1
     * Store basic details (name, email, dob, password)
     * Works like SESSION but via CACHE
     * ---------------------------------------------------------
     */
    public function storeDetails(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'dob'      => 'nullable|date',
            'password' => 'required|min:8|confirmed',
        ]);

        // Temp key = API session id
        $tempKey = 'reg_' . Str::uuid();

        Cache::put($tempKey, [
            'name'     => $request->name,
            'email'    => $request->email,
            'dob'      => $request->dob,
            'password' => $request->password,
        ], now()->addMinutes(10));

        return response()->json([
            'status'   => 'success',
            'message'  => 'Registration details saved',
            'temp_key' => $tempKey,
        ]);
    }

    /**
     * ---------------------------------------------------------
     * STEP 2
     * Take phone number & send OTP
     * ---------------------------------------------------------
     */
  public function sendOtp(Request $request)
{
    $request->validate([
        'temp_key' => 'required|string',
        'phone'    => 'required|digits:10|unique:users,phone',
    ]);

    $data = Cache::get($request->temp_key);

    if (!$data) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Registration session expired',
        ], 422);
    }

    $otp = rand(100000, 999999);

    // Save phone + otp in cache
    Cache::put($request->temp_key, array_merge($data, [
        'phone' => $request->phone,
        'otp'   => $otp,
    ]), now()->addMinutes(5));

    // 🔹 SEND OTP USING YOUR SMS API
    $smsSent = $this->sendOtpSms($request->phone, $otp);

    if (!$smsSent) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to send OTP. Please try again.',
        ], 500);
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'OTP sent successfully',
    ]);
}


    /**
     * ---------------------------------------------------------
     * STEP 3
     * Verify OTP & create user
     * ---------------------------------------------------------
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'temp_key' => 'required|string',
            'otp'      => 'required|digits:6',
        ]);

        $data = Cache::get($request->temp_key);

        if (!$data || !isset($data['otp']) || $data['otp'] != $request->otp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid or expired OTP',
            ], 422);
        }

        // Create user
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'dob'      => $data['dob'],
            'password' => Hash::make($data['password']),
        ]);

        // Ensure role exists
        if (!Role::where('name', 'customer')->exists()) {
            Role::create(['name' => 'customer']);
        }

        // Assign role
        $user->assignRole('customer');

        // Create Sanctum token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Clear cache
        Cache::forget($request->temp_key);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration successful',
            'token'   => $token,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role'  => 'customer',
            ],
        ]);
    }


    private function sendOtpSms($phone, $otp)
{
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

    logger('SMS API Response: ' . $response->body());

    return $response->successful();
}

}
