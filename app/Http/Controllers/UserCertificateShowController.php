<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCertificateShowController extends Controller
{
    /**
     * Display a listing of the user's certificates.
     */
    public function index()
    {
        // Sirf logged-in user ke 'active' certificates dikhane ke liye
        $certificates = Certificate::where('user_id', Auth::id())
            ->where('status', 'active') 
            ->orderBy('issue_date', 'desc')
            ->get();

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Download the certificate file.
     */
    public function download(Certificate $certificate)
    {
        // Security check: User apna hi certificate download kar sake
        if ($certificate->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $path = storage_path('app/public/' . $certificate->file_path);
        
        if (!file_exists($path)) {
            return back()->with('error', 'Certificate file not found.');
        }

        return response()->download($path);
    }
}