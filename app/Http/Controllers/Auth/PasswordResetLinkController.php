<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetOtpMail;


class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

//     public function store(Request $request)
// {
//     $request->validate(['identity' => 'required|string']);
//     $identity = $request->identity;
    
//     $isEmail = filter_var($identity, FILTER_VALIDATE_EMAIL);
//     $attempts = session()->get('forgot_email_attempts', 0);

//     // Agar 3 tries ho chuki hain aur user phir bhi Email dal raha hai
//     if ($attempts >= 30 && $isEmail) {
//         return back()->withErrors([
//             'identity' => 'Email method is locked. Please enter your Mobile Number.'
//         ]);
//     }

//     // Check if user exists in DB
//     $user = $isEmail 
//             ? User::where('email', $identity)->first() 
//             : User::where('phone', $identity)->first();

//     if (!$user) {
//         return back()->withErrors(['identity' => 'This ' . ($isEmail ? 'email' : 'mobile number') . ' is not registered.']);
//     }

//     // Logic for sending OTP
//     $otp = rand(100000, 999999);
//     session()->put('reset_otp', $otp);
//     session()->put('reset_identity', $identity);

//     if ($isEmail) {
//         // Increment email attempts
//         session()->put('forgot_email_attempts', $attempts + 1);
//         // Mail::to($identity)->send(new ResetOtpMail($otp));
//     } else {
//         // Send SMS logic
//         $this->sendOtpSms($identity, $otp);
//     }

//     return redirect()->route('password.verify.view')->with('status', 'OTP sent successfully!');
// }

// public function store(Request $request)
// {
//     $request->validate(['identity' => 'required|string']);
//     $identity = $request->identity;
    
//     $isEmail = filter_var($identity, FILTER_VALIDATE_EMAIL);
//     $attempts = session()->get('forgot_email_attempts', 0);

//     // 1. Email Limit Check (Sirf 3 baar allow karein)
//     if ($isEmail && $attempts >= 30) {
//         return back()->withErrors([
//             'identity' => 'Email OTP limit reached. Please use your registered Mobile Number now.'
//         ]);
//     }

//     // 2. User Check in Database
//     $user = $isEmail 
//             ? \App\Models\User::where('email', $identity)->first() 
//             : \App\Models\User::where('phone', $identity)->first();

//     if (!$user) {
//         return back()->withErrors([
//             'identity' => 'This ' . ($isEmail ? 'email' : 'mobile number') . ' is not registered with us.'
//         ]);
//     }

//     // 3. OTP Generation
//     $otp = rand(100000, 999999);
//     session()->put('reset_otp', $otp);
//     session()->put('reset_identity', $identity);

//     // 4. Send OTP based on Identity Type
//     if ($isEmail) {
//         // Increment attempts
//         session()->put('forgot_email_attempts', $attempts + 1);

//         // Send Mail
//         try {
//             \Illuminate\Support\Facades\Mail::to($identity)->send(new \App\Mail\ResetOtpMail($otp));
//         } catch (\Exception $e) {
//             return back()->withErrors(['identity' => 'Failed to send email. Please try mobile or check settings.']);
//         }
//     } else {
//         // Send SMS (Aapka existing function)
//         $smsSent = $this->sendOtpSms($identity, $otp);
        
//         if (!$smsSent) {
//             return back()->withErrors(['identity' => 'Failed to send SMS. Please try again later.']);
//         }
//     }

//     return redirect()->route('password.verify.view')->with('status', 'OTP sent successfully!');
// }


public function store(Request $request)
{
    $request->validate(['identity' => 'required|string']);
    $identity = $request->identity;

    $isEmail  = filter_var($identity, FILTER_VALIDATE_EMAIL);
    $attempts = session()->get('forgot_email_attempts', 0);

    // Email attempt limit
    if ($isEmail && $attempts >= 30) {
        return back()->withErrors([
            'identity' => 'Email OTP limit reached. Please use your registered mobile number.'
        ]);
    }

    // User check
    $user = $isEmail
        ? \App\Models\User::where('email', $identity)->first()
        : \App\Models\User::where('phone', $identity)->first();

    if (!$user) {
        return back()->withErrors([
            'identity' => 'This ' . ($isEmail ? 'email' : 'mobile number') . ' is not registered with us.'
        ]);
    }

    // OTP generate (secure)
    $otp = random_int(100000, 999999);

    session()->put('reset_otp', $otp);
    session()->put('reset_identity', $identity);

    if ($isEmail) {
        session()->put('forgot_email_attempts', $attempts + 1);

        try {
            Mail::send([], [], function ($message) use ($identity, $otp, $user) {

                $message->to($identity)
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Your Password Reset OTP')
                    ->html("
                        <div style='font-family:Arial;padding:20px'>
                            <h2>Hello " . ($user->name ?? 'User') . ",</h2>
                            <p>You requested to reset your password.</p>
                            <p>Your OTP is:</p>
                            <h1 style='letter-spacing:4px;color:#2563eb'>{$otp}</h1>
                            <p>This OTP is valid for 10 minutes.</p>
                            <p style='font-size:12px;color:#888'>
                                If you did not request this, please ignore this email.
                            </p>
                        </div>
                    ");
            });

        } catch (\Exception $e) {
            return back()->withErrors([
                'identity' => 'Unable to send OTP email. Please try again or use mobile.'
            ]);
        }

    } else {
        // SMS OTP
        if (!$this->sendOtpSms($identity, $otp)) {
            return back()->withErrors([
                'identity' => 'Failed to send SMS. Please try again later.'
            ]);
        }
    }

    return redirect()
        ->route('password.verify.view')
        ->with('status', 'OTP sent successfully!');
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