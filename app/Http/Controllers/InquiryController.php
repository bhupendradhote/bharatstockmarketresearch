<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'email'      => 'nullable|email',
            'phone'      => 'nullable|string|max:20',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string',
        ]);

        Inquiry::create([
            'user_id'    => Auth::check() ? Auth::id() : null,
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'subject'    => $validated['subject'] ?? null,
            'message'    => $validated['message'],
        ]);

        return back()->with('success', 'Inquiry submitted successfully!');
    }
}
