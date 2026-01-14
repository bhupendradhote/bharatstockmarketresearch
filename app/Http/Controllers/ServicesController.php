<?php

namespace App\Http\Controllers;

use App\Models\HeroBanner;
use App\Models\Faq;
use App\Models\ServicePlan;
use Illuminate\Http\Request;
use App\Models\ContactDetail;


class ServicesController extends Controller
{
    /**
     * Show the Services page
     */
    public function index()
    {
        /* ---------------- HERO BANNER ---------------- */
        $banner = HeroBanner::where('page_key', 'services')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->first();

        /* ---------------- FAQs ---------------- */
        $faqs = Faq::where('page_type', 'service')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        /* ---------------- SERVICE PLANS ---------------- */
        $plans = ServicePlan::with([
                'durations' => function ($q) {
                    $q->orderBy('duration');
                },
                'durations.features'
            ])
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();
        
            // ✅ CONTACT DETAILS (single record)
            $contactDetail = ContactDetail::where('is_active', 1)->first();

        return view('services', compact(
            'banner',
            'faqs',
            'plans',
            'contactDetail'
        ));
    }
}
