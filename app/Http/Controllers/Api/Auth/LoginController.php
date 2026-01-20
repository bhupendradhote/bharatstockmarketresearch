<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * API Login with Email or Phone + Password
     */
    public function login(Request $request)
    {
        // 1️⃣ Validate request
        $request->validate([
            'login_identity' => 'required|string',
            'password'       => 'required|string|min:6',
        ]);

        $loginValue = $request->login_identity;
        $password   = $request->password;

        // 2️⃣ Detect email or phone
        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        // 3️⃣ Find user
        $user = User::where($field, $loginValue)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login_identity' => ['User not found.'],
            ]);
        }

        // 4️⃣ Verify password
        if (!Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Invalid password.'],
            ]);
        }

        // 5️⃣ Create Sanctum token
        $token = $user->createToken('auth-token')->plainTextToken;

        // 6️⃣ Success response
        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role'  => $user->getRoleNames()->first(),
            ],
        ]);
    }
}
