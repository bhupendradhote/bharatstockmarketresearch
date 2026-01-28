<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Carbon\Carbon;

class CertificateController extends Controller
{
    /**
     * Display a listing of the certificates.
     */
   public function index(Request $request)
{
    $query = Certificate::with('user');

    // Search filter
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where('certificate_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('certificate_number', 'LIKE', "%{$searchTerm}%");
    }

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $certificates = $query->latest()->paginate(12);
    $users = User::select('id', 'name')->get();

    return view('admin.certificates.index', compact('certificates', 'users'));
}
    /**
     * Show the form for creating a new certificate.
     */
    public function create()
    {
        $users = User::all(); // For the dropdown to select which customer gets the cert
        return view('admin.certificates.create', compact('users'));
    }

 /**
 * Store a newly created certificate in storage.
 */
public function store(Request $request)
{
    $request->validate([
        'certificate_name' => 'required|string|max:255',
        'issue_date'       => 'nullable|date',
        'expiry_date'      => 'nullable|date|after_or_equal:issue_date',
        'file'             => 'required|file|mimes:pdf,jpg,png,jpeg|max:5120', 
    ]);

    $data = $request->except('file');
    $data['user_id'] = auth()->id();

    // --- Status Calculation Logic ---
    // Agar expiry date aaj se pehle ki hai, toh status 'expired' hoga
    if ($request->filled('expiry_date') && \Carbon\Carbon::parse($request->expiry_date)->isPast()) {
        $data['status'] = 'expired';
    } else {
        $data['status'] = 'active';
    }

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $data['file_path'] = $file->storeAs('certificates', $fileName, 'public');
        $data['file_extension'] = $file->getClientOriginalExtension();
    }

    Certificate::create($data);

    return redirect()->route('admin.certificates.index')
        ->with('success', 'Certificate uploaded and status set to ' . $data['status']);
}



    /**
     * Show the form for editing the certificate.
     */
    public function edit(Certificate $certificate)
    {
        $users = User::all();
        return view('admin.certificates.edit', compact('certificate', 'users'));
    }

    /**
     * Update the specified certificate in storage.
     */

/**
 * Update the specified certificate in storage.
 */
public function update(Request $request, Certificate $certificate)
{
    $request->validate([
        'certificate_name' => 'required|string|max:255',
        'issue_date'       => 'nullable|date',
        'expiry_date'      => 'nullable|date|after_or_equal:issue_date',
        'file'             => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
    ]);

    $data = $request->except('file');
    $data['user_id'] = auth()->id();

    // --- Status Recalculation ---
    if ($request->filled('expiry_date') && \Carbon\Carbon::parse($request->expiry_date)->isPast()) {
        $data['status'] = 'expired';
    } else {
        $data['status'] = 'active';
    }

    if ($request->hasFile('file')) {
        if ($certificate->file_path && \Storage::disk('public')->exists($certificate->file_path)) {
            \Storage::disk('public')->delete($certificate->file_path);
        }

        $file = $request->file('file');
        $fileName = auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $data['file_path'] = $file->storeAs('certificates', $fileName, 'public');
        $data['file_extension'] = $file->getClientOriginalExtension();
    }

    $certificate->update($data);

    return redirect()->route('admin.certificates.index')
        ->with('success', 'Certificate updated. Status is now ' . $data['status']);
}

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Certificate $certificate)
    {
        if ($certificate->file_path) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }
}