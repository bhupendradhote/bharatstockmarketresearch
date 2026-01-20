<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{


    public function create()
    {
        return view('auth.register');
    }

    // Step 1: Details validate karke session mein save karna
    public function handleDetails(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'dob'      => 'nullable|date',
            'password' => 'required|min:8|confirmed', // 'confirmed' automatically 'password_confirmation' check karta hai
        ]);

        // Sabhi details ko session mein 'reg_data' key ke andar save karein
        Session::put('reg_data', $request->only('name', 'email', 'dob', 'password'));

        // Agle step (Phone Input) par redirect karein
        return redirect()->route('register.phone');
    }

    // Step 2: Mobile Number form dikhana
    public function showPhoneForm()
    {
        // CONDITION: Agar session mein 'reg_data' key nahi milti (yani user ne step 1 skip kiya)
        // ya phir agar session khali hai, toh use wapas register page pe bhej do.
        if (!Session::has('reg_data') || empty(Session::get('reg_data'))) {
            return redirect()->route('register')->withErrors(['msg' => 'Please fill your registration details first.']);
        }

        // Agar details hain, tabhi yeh view load hoga
        return view('auth.register-phone');
    }

    // Step 3: Mobile number lekar OTP bhejna
    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10|unique:users,phone',
        ]);

        $otp = rand(100000, 999999);
        
        Session::put('reg_otp', $otp);
        Session::put('reg_phone', $request->phone);

        $this->sendOtpSms($request->phone, $otp);

        // FIX 1: View ka sahi naam use karein (otp_verify_register)
        return view('auth.otp_verify_register', [
            'phone' => $request->phone,
            'route' => route('register.verify_otp') 
        ]);
    }

    // Step 4: Final Database Entry
    public function verifyAndRegister(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $sessionOtp = Session::get('reg_otp');
        $userData = Session::get('reg_data');
        $phone = Session::get('reg_phone'); // FIX 2: Phone session se lein

        if ($request->otp == $sessionOtp) {
            // OTP match ho gaya, ab user create karo
            $user = User::create([
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                'phone'    => $phone, // Correct phone number                
                'password' => Hash::make($userData['password']), 
            ]);

            if (!Role::where('name', 'customer')->exists()) {
                Role::create(['name' => 'customer']);
            }
            $user->assignRole('customer');

            Auth::login($user);

            // Session saaf karo
            // Session::forget(['reg_otp', 'reg_data', 'reg_phone']);
            Session::forget(['reg_data', 'reg_otp', 'reg_phone']);

            return redirect('/dashboard')->with('success', 'Registration Successful!');
        }

        return back()->withErrors(['otp' => 'Invalid OTP, please try again.']);
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
