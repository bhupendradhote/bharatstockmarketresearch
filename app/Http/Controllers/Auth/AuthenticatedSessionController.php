<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;



class AuthenticatedSessionController extends Controller
{
    // Show login/register form
  public function create()
{
    // If already logged in → redirect to home page
    if (Auth::check()) {
        return redirect('/');
    }

    return view('auth.login');
}



// public function store(Request $request)
// {
//     // 1. Validation: login_identity aur password dono zaroori hain
//     $request->validate([
//         'login_identity' => 'required|string',
//         'password'       => 'required|string',
//     ]);

//     $loginValue = $request->input('login_identity');
//     $password = $request->input('password');

//     // 2. Check karna ki input Email hai ya Phone Number
//     // Agar input mein '@' hai toh Email mano, varna Phone
//     $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

//     // 3. Attempt Login
//     // Auth::attempt check karta hai ki user DB mein hai aur password match hota hai ya nahi
//     if (Auth::attempt([$fieldType => $loginValue, 'password' => $password], $request->boolean('remember'))) {
        
//         // Session regenerate karna security ke liye acha hota hai
//         $request->session()->regenerate();

//         return redirect()->intended('/') // User jahan jana chahta tha wahan bhej do varna Home par
//             ->with('success', 'Welcome back! Login successful.');
//     }

//     // 4. Agar login fail ho jaye
//     return back()->withErrors([
//         'login_identity' => 'The provided credentials do not match our records.',
//     ])->withInput($request->only('login_identity'));
// }


public function store(Request $request)
{
    // 1. Validation
    $request->validate([
        'login_identity' => 'required|string',
        'password'       => 'required|string',
    ]);

    $loginValue = $request->input('login_identity');
    $password = $request->input('password');

    // 2. Identify Email or Phone
    $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    // 3. Attempt Login
    if (Auth::attempt([$fieldType => $loginValue, 'password' => $password], $request->boolean('remember'))) {
        
        $request->session()->regenerate();

        $user = Auth::user();

        // Spatie Role Check: hasRole method use karein
        if ($user->hasRole('super-admin')) {
            return redirect()->intended('admin/dashboard')
                ->with('success', 'Welcome Admin! Login successful.');
        }

        // Default redirect for normal users
        return redirect()->intended('/dashboard')
            ->with('success', 'Welcome back! Login successful.');
    }

    // 4. Fail Case
    return back()->withErrors([
        'login_identity' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('login_identity'));
}

      




        // Logout
        public function destroy(Request $request)
        {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        }
}
