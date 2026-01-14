<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroBanner;
use App\Models\Faq;
use App\Models\Page; 
use App\Models\ContactDetail;


class ContactController extends Controller
{
    /**
     * Show Contact Page
     */
    public function index()
    {
        // CONTACT PAGE CONTENT
        $banner = HeroBanner::where('page_key', 'contact')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->first();
        // CONTACT PAGE FAQs (optional)
        $faqs = Faq::active()
            ->forPage('contact')
            ->orderBy('sort_order')
            ->get();
        // ✅ CONTACT DETAILS (single record)
        $contactDetail = ContactDetail::where('is_active', 1)->first();


        return view('contact', [
            'banner' => $banner,
            'faqs'   => $faqs,
            'contactDetail' => $contactDetail,
        ]);
    }
}
