<?php

namespace App\Http\Controllers;

use App\Models\HeroBanner;
use App\Models\AboutMissionValue;
use App\Models\AboutCoreValueSection;
use App\Models\AboutWhyPlatformSection;
use App\Models\DownloadAppSection;


class AboutController extends Controller
{
    public function index()
    {
        // Hero banner
        $banner = HeroBanner::where('page_key', 'about')->first();

        // Mission & Values (single / top)
        $mission = AboutMissionValue::where('is_active', 1)
            ->orderBy('sort_order')
            ->first();

        // Core Values Section + values
        $coreSection = AboutCoreValueSection::where('is_active', 1)
            ->with(['values' => function ($q) {
                $q->where('is_active', 1);
            }])
            ->orderBy('sort_order')
            ->first();

    // Why Platform Sections + contents (MULTIPLE)
$whyPlatforms = AboutWhyPlatformSection::where('is_active', 1)
    ->with(['contents' => function ($q) {
        $q->where('is_active', 1)->orderBy('sort_order');
    }])
    ->orderBy('sort_order')
    ->get();

    // ✅ DOWNLOAD APP SECTION (ABOUT PAGE)
$downloadApp = DownloadAppSection::where('page_key', 'about')
    ->where('is_active', 1)
    ->first();

        return view('about', compact(
            'banner',
            'mission',
            'coreSection',
            'whyPlatforms',
            'downloadApp'
        ));
    }
}
