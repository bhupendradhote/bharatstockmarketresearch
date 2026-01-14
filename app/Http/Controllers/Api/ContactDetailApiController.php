<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use Illuminate\Http\Request;

class ContactDetailApiController extends Controller
{
    // ================= FETCH CONTACT DETAILS =================
    public function show()
    {
        $contact = ContactDetail::first();

        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }

    // ================= CREATE OR UPDATE CONTACT DETAILS =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // 🔑 Only one row allowed
        $contact = ContactDetail::first();

        if ($contact) {
            $contact->update($data);
        } else {
            $contact = ContactDetail::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Contact details saved successfully',
            'data' => $contact
        ]);
    }
}
