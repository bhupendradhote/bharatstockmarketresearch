<?php

namespace App\Http\Controllers;

use App\Models\HeroBanner;
use App\Models\HomeCounter;
use Illuminate\Http\Request;
use App\Models\WhyChooseSection;
use App\Models\HowItWorksSection;
use App\Models\HomeKeyFeatureSection;
use App\Models\Faq;
use App\Models\Review;
use App\Models\ServicePlan;
use App\Models\DownloadAppSection;
use App\Models\ContactDetail;
use App\Models\OfferBanner;




class HomeController extends Controller
{
    /**
     * Show Home Page
     */
    public function index()
    {
        // Hero banner
        $banner = HeroBanner::where('page_key', 'home')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->first();

        // Stats / Counters
        $counters = HomeCounter::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();


               // WHY CHOOSE US (single section)
            $whyChoose = WhyChooseSection::where('is_active', 1)
                ->orderBy('sort_order')
                ->first();

              // HOW IT WORKS (single active section with steps)
            $howItWorks = HowItWorksSection::with([
                    'steps' => fn ($q) => $q->where('is_active', 1)->orderBy('sort_order')
                ])
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->first();


            // ✅ KEY FEATURES (single section + 3 images)
        $keyFeatures = HomeKeyFeatureSection::with([
                'items' => fn ($q) => $q->where('is_active', 1)->orderBy('sort_order')
            ])
            ->where('is_active', 1)
            ->first();

            // ✅ SERVICE PLANS WITH DURATIONS & FEATURES
            $plans = ServicePlan::with([
                'durations.features'
            ])
            ->where('status', 1)
             ->where('featured', 1)
            ->orderBy('sort_order')
            ->get();

          // ✅ FAQ (HOME PAGE)
            $faqs = Faq::active()
                ->forPage('Home')   // 👈 THIS IS THE KEY
                ->orderBy('sort_order')
                ->get();

                $testimonials = Review::
                // where('status', true)
    // ->whereNotNull('user_id')
    latest()
    ->take(10)
    ->get();
    // ✅ CONTACT DETAILS (single record)
$contactDetail = ContactDetail::where('is_active', 1)->first();

    // ✅ DOWNLOAD APP SECTION (single section)
        $downloadApp = DownloadAppSection::where('page_key', 'home')
            ->where('is_active', 1)
            ->first();

            // ✅ Subscription Expiry Check logic add karein
    if (auth()->check()) {
        $user = auth()->user();
        $now = \Carbon\Carbon::now();
        
        $activeSub = \App\Models\UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', $now)
            ->first();

        if ($activeSub) {
            $daysLeft = (int) $now->diffInDays($activeSub->end_date, false);
            if ($daysLeft >= 0 && $daysLeft <= 3) {
                // Session mein flash karein taaki Layout file ise read kar sake
                session()->flash('plan_expiring_days', $daysLeft);
            }
        }
    }
    
      // Marquees Section 
            $marquees = \App\Models\Marquee::active()
                ->orderBy('display_order', 'asc')
                ->get();

     // Offer Banners Section
        $offerBanner = OfferBanner::active()
            ->latest()
            ->first();

        return view('home', [
            'banner'   => $banner,
            'counters' => $counters,
            'whyChoose'=> $whyChoose,
            'howItWorks'=> $howItWorks,
            'keyFeatures'=> $keyFeatures,
            'faqs'     => $faqs,
            'testimonials' => $testimonials,
            'plans'    => $plans,
            'downloadApp' => $downloadApp,
            'contactDetail' => $contactDetail,
            'activeSubscription' => $activeSub ?? null,
                'marquees' => $marquees,
                        'offerBanner' => $offerBanner,

        ]);
    }
}
