<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use Illuminate\Http\Request;

class ContactDetailController extends Controller
{
    public function index()
    {
        $contact = ContactDetail::first();

        return view('admin.contact-details.index', compact('contact'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // ✅ if already exists → update
        $contact = ContactDetail::first();

        if ($contact) {
            $contact->update($data);
        } else {
            ContactDetail::create($data);
        }

        return back()->with('success', 'Contact details saved');
    }
}
