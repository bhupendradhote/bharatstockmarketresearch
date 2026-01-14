<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryApiController extends Controller
{
    // ================= STORE INQUIRY =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string',
        ]);

        $inquiry = Inquiry::create([
            'user_id'    => Auth::check() ? Auth::id() : null,
            'first_name' => $validated['first_name'] ?? null,
            'last_name'  => $validated['last_name'] ?? null,
            'email'      => $validated['email'] ?? null,
            'phone'      => $validated['phone'] ?? null,
            'subject'    => $validated['subject'] ?? null,
            'message'    => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry submitted successfully',
            'data' => [
                'id' => $inquiry->id
            ]
        ], 201);
    }
}
