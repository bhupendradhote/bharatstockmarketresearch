<?php 
namespace App\Http\Controllers;

use App\Models\PolicyMaster;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        // Sirf Privacy Policy ka data fetch karein
        $policy = PolicyMaster::where('slug', 'privacy-policy')
                    ->where('is_enabled', 1)
                    ->with(['activeContent' => function($query) {
                        $query->where('is_active', 1);
                    }])
                    ->firstOrFail();

        return view('frontend.policies.privacy', compact('policy'));
    }
}