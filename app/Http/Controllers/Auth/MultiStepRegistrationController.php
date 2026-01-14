<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class MultiStepRegistrationController extends Controller
{
    // Show registration form after OTP verification
    public function showRegistrationForm(Request $request)
    {
         $tempUser = [
                        'phone' => $request->phone,
                        'name' => null,
                    ];
        \Illuminate\Support\Facades\Cache::put('temp_user_' . $request->phone, $tempUser, now()->addMinutes(30));
        $phone = $request->phone;

        $tempUser = Cache::get('temp_user_' . $phone); // Use cache for temp user

        // if (!$tempUser) {
        //     return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        // }

        return view('auth.register-multistep', [
            'phone' => $phone,
            'step' => $request->step ?? 1,
            'userData' => $tempUser
        ]);
    }

    // Complete registration
  public function completeRegistration(Request $request)
{
    $userData = $request->except(['_token', 'phone', 'step']); // All submitted fields

    // Get currently logged-in user
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Session expired. Please login again.');
    }

    // Update user details
    $user->update([
        'name' => $userData['name'] ?? $user->name,
        'email' => $userData['email'] ?? $user->email,
        'dob' => $userData['dob'] ?? $user->dob,
        'gender' => $userData['gender'] ?? $user->gender,
        'marital_status' => $userData['marital_status'] ?? $user->marital_status,
        'blood_group' => $userData['blood_group'] ?? $user->blood_group,
        'address' => $userData['address'] ?? $user->address,
        'city' => $userData['city'] ?? $user->city,
        'state' => $userData['state'] ?? $user->state,
        'pincode' => $userData['pincode'] ?? $user->pincode,
        'country' => $userData['country'] ?? $user->country,
        'business_name' => $userData['business_name'] ?? $user->business_name,
        'business_type' => $userData['business_type'] ?? $user->business_type,
        'education_institute' => $userData['education_institute'] ?? $user->education_institute,
        'education_degree' => $userData['education_degree'] ?? $user->education_degree,
        'bio' => $userData['bio'] ?? $user->bio,
        'hobbies' => $userData['hobbies'] ?? $user->hobbies,
        'skills' => $userData['skills'] ?? $user->skills,
    ]);

    return redirect()->route('home')
        ->with('success', 'Registration completed successfully!');
}


    // Skip registration
public function skipRegistration(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    $phone = $request->phone;
    $tempUser = Cache::get('temp_user_' . $phone);

    if (!$tempUser) {
        return redirect()->route('login')->with('error', 'Session expired.');
    }

    // Find the existing user
    $user = User::where('phone', $phone)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'User not found.');
    }

    // Update user with provided name and email
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Assign customer role if not already assigned
    if (! $user->hasRole('customer')) {
        if (!\Spatie\Permission\Models\Role::where('name', 'customer')->exists()) {
            \Spatie\Permission\Models\Role::create(['name' => 'customer']);
        }
        $user->assignRole('customer');
    }

    Auth::login($user);
    Cache::forget('temp_user_' . $phone);

    return redirect()->route('dashboard')
        ->with('info', 'You can update your profile later.');
}


}
