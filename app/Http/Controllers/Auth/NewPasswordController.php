<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NewPasswordController extends Controller
{
 public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $sessionOtp = Session::get('reset_otp');
        $identity = Session::get('reset_identity');

        // 2. OTP Verification
        if ($request->otp != $sessionOtp) {
            // Yahan humne redirect change kiya hai
            // User ko wapas identity page par bhej rahe hain
            return redirect()->route('password.request')
                ->withErrors(['identity' => 'Invalid OTP or session expired. Please request a new OTP.']);
        }

        // 3. User ko find karein
        $isEmail = filter_var($identity, FILTER_VALIDATE_EMAIL);
        $user = $isEmail 
                ? User::where('email', $identity)->first() 
                : User::where('phone', $identity)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['identity' => 'User session expired. Please try again.']);
        }

        // 4. Password Update
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        // 5. Session Clear
        Session::forget(['reset_otp', 'reset_identity', 'forgot_email_attempts']);

        // 6. Login & Redirect
        Auth::login($user);

        return redirect('/')->with('success', 'Password updated and logged in successfully!');
    }
}