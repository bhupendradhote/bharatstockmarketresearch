<?php 
namespace App\Http\Controllers;

use App\Models\PolicyMaster;

class PolicyDisplayController extends Controller
{
    private function getPolicy($slug) {
        return PolicyMaster::where('slug', $slug)
            ->where('is_enabled', 1)
            ->with(['activeContent' => fn($q) => $q->where('is_active', 1)])
            ->firstOrFail();
    }

    public function privacy() {
        $policy = $this->getPolicy('privacy-policy');
        return view('privacy-policy', compact('policy'));
    }

    public function terms() {
        $policy = $this->getPolicy('terms-and-conditions');
        return view('terms-and-conditions', compact('policy'));
    }

    public function grievance() {
        $policy = $this->getPolicy('grievance-redressal-policy');
        return view('grievance-redressal-policy', compact('policy'));
    }
}