<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    // Send OTP (login or auto-register)
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();

        $otp = rand(100000, 999999);
        
        // Store OTP in cache for 10 minutes
        Cache::put("otp_{$phone}", [
            'code' => $otp,
            'user_exists' => $user ? true : false
        ], now()->addMinutes(10));

        // TODO: send OTP via SMS (Twilio, MSG91, etc)
        logger("API OTP for {$phone}: {$otp}");

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully',
            'otp' => $otp // remove in production
        ]);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|digits:6',
        ]);

        $phone = $request->phone;
        $enteredOtp = $request->otp;
        
        // Get OTP from cache
        $otpData = Cache::get("otp_{$phone}");
        
        if (!$otpData || $otpData['code'] != $enteredOtp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired OTP'
            ], 422);
        }

        // Login or register
        if ($otpData['user_exists']) {
            $user = User::where('phone', $phone)->first();
        } else {
            $user = User::create([
                'phone' => $phone,
                'password' => Hash::make($phone),
                'name' => 'User_' . substr($phone, -4), 
            ]);
        }

        // Create API token
        $token = $user->createToken('api-token')->plainTextToken;

        // Clear OTP from cache
        Cache::forget("otp_{$phone}");

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully',
            'user' => [
                'id' => $user->id,
                'phone' => $user->phone,
                'name' => $user->name,
            ],
            'token' => $token,
        ]);
    }


    // Logout (revoke tokens)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out'
        ]);
    }
}