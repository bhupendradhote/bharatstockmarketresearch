<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use App\Models\HomeCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WhyChooseSection;
use App\Models\HowItWorksSection;
use App\Models\HowItWorksStep;
use App\Models\HomeKeyFeatureSection;
use App\Models\HomeKeyFeatureItem;
use App\Models\DownloadAppSection;

class AdminHomeController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::where('page_key', 'home')
            ->orderBy('sort_order')
            ->get();

        $counters = HomeCounter::orderBy('sort_order')->get();

        return view('admin.home.index', compact('banners', 'counters'));
    }


    // ================ COUNTERS =================

   // ================ COUNTERS =================

public function storeCounter(Request $request)
{
    $data = $request->validate([
        'value' => 'required|string|max:20',
        'description' => 'required|string|max:255',
        'is_active' => 'boolean',
    ]);

    $data['is_active'] = $request->boolean('is_active');

    // Automatically set sort_order: find the max current order and add 1
    // If no records exist, it starts at 1
    $data['sort_order'] = HomeCounter::max('sort_order') + 1;

    HomeCounter::create($data);

    return response()->json(['success' => true]);
}

public function updateCounter(Request $request, HomeCounter $counter)
{
    $data = $request->validate([
        'value' => 'required|string|max:20',
        'description' => 'required|string|max:255',
        'is_active' => 'boolean',
    ]);

    $data['is_active'] = $request->boolean('is_active');
    
    // We don't update sort_order here because your 
    // saveOrder() function handles the reordering logic.

    $counter->update($data);

    return response()->json(['success' => true]);
}

    public function deleteCounter(HomeCounter $counter)
    {
        $counter->delete();

        return response()->json(['success' => true]);
    }
    public function toggleCounter(HomeCounter $counter)
{
    $counter->update([
        'is_active' => !$counter->is_active
    ]);

    return response()->json([
        'success' => true,
        'status' => $counter->is_active
    ]);
}



public function reorderCounters(Request $request)
{
    $order = $request->input('order');

    if (!is_array($order)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid order payload'
        ], 422);
    }

    DB::transaction(function () use ($order) {
        foreach ($order as $index => $id) {
            HomeCounter::where('id', (int) $id)->update([
                'sort_order' => $index + 1
            ]);
        }
    });

    return response()->json([
        'success' => true
    ]);
}

public function destroyCounter(HomeCounter $counter)
{
    // 1. Record delete karo
    $counter->delete();

    // 2. Baaki bache huye counters ko sort_order ke hisaab se fetch karo
    $remainingCounters = HomeCounter::orderBy('sort_order')->get();

    // 3. Loop chala kar sequence reset karo (1, 2, 3...)
    foreach ($remainingCounters as $index => $item) {
        $item->update(['sort_order' => $index + 1]);
    }

    return response()->json(['success' => true]);
}



        /* ================= WHY CHOOSE ================= */

        public function whyChooseIndex()
        {
            $whyChoose = WhyChooseSection::orderBy('sort_order')->get();

            return view('admin.home.why-choose', compact('whyChoose'));
        }

       public function whyChooseStore(Request $request)
{
    $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'badge' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    $data['is_active'] = $request->has('is_active');

    $section = WhyChooseSection::create($data);

    if ($request->hasFile('image')) {
        $section
            ->addMediaFromRequest('image')
            ->toMediaCollection('why_choose_image');
    }

    return response()->json(['success' => true]);
}


       public function whyChooseUpdate(Request $request, WhyChooseSection $section)
{
    $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'badge' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    $data['is_active'] = $request->has('is_active');

    $section->update($data);

    if ($request->hasFile('image')) {
        $section->clearMediaCollection('why_choose_image');
        $section
            ->addMediaFromRequest('image')
            ->toMediaCollection('why_choose_image');
    }

    return response()->json(['success' => true]);
}


        public function whyChooseDelete(WhyChooseSection $section)
        {
            $section->clearMediaCollection('why_choose_image');
            $section->delete();

            return response()->json(['success' => true]);
        }

        public function whyChooseReorder(Request $request)
        {
            DB::transaction(function () use ($request) {
                foreach ($request->order as $index => $id) {
                    WhyChooseSection::where('id', (int) $id)->update([
                        'sort_order' => $index + 1
                    ]);
                }
            });

            return response()->json(['success' => true]);
        }

        public function whyChooseToggle(WhyChooseSection $section)
        {
            $section->update(['is_active' => !$section->is_active]);

            return response()->json([
                'success' => true,
                'status' => $section->is_active
            ]);
        }


        /* ================= HOW IT WORKS ================= */

            public function howItWorksIndex()
        {
            $sections = HowItWorksSection::orderBy('id')->get();

            $section = request('section')
                ? HowItWorksSection::with('steps')->find(request('section'))
                : HowItWorksSection::with('steps')->first();

            // 🔥 ADD IMAGE URL FOR EACH STEP
            if ($section) {
                $section->steps->transform(function ($step) {
                    $step->image_url = $step->getFirstMediaUrl('how_it_works_step');
                    return $step;
                });
            }

            return view('admin.home.how-it-works', [
                'sections' => $sections,
                'section'  => $section,
                'steps'    => $section?->steps ?? collect(),
            ]);
        }


        /**
         * STORE + UPDATE SECTION & STEPS (SINGLE FUNCTION)
         */


        public function howItWorksSave(Request $request)
        {
            $sectionData = json_decode($request->section, true);

            DB::transaction(function () use ($request, $sectionData) {

                /* ================= SECTION ================= */
                $section = HowItWorksSection::updateOrCreate(
                    ['id' => $sectionData['id'] ?? null],
                    [
                        'badge'       => $sectionData['badge'] ?? null,
                        'heading'     => $sectionData['heading'] ?? null,
                        'sub_heading' => $sectionData['sub_heading'] ?? null,
                        'description' => $sectionData['description'] ?? null,
                        'is_active'   => $sectionData['is_active'] ?? false,
                    ]
                );

                $keptStepIds = [];

                /* ================= STEPS ================= */
                foreach ($request->steps as $index => $stepData) {

                    // 🔑 IMPORTANT: firstOrNew instead of updateOrCreate
                    $step = HowItWorksStep::firstOrNew([
                        'id' => $stepData['id'] ?? null
                    ]);

                    $step->section_id = $section->id;
                    $step->title = $stepData['title'];
                    $step->description = $stepData['description'] ?? '';
                    $step->is_active = $stepData['is_active'] ?? false;
                    $step->sort_order = $index + 1;
                    $step->save();

                    /* ================= IMAGE UPLOAD ================= */
                    if ($request->hasFile("steps.$index.image")) {

                        // 🔥 force delete old media
                        if ($step->hasMedia('how_it_works_step')) {
                            $step->clearMediaCollection('how_it_works_step');
                        }

                        $step
                            ->addMediaFromRequest("steps.$index.image")
                            ->usingFileName(
                                'step_' . $step->id . '_' . time() . '.' .
                                $request->file("steps.$index.image")->getClientOriginalExtension()
                            )
                            ->toMediaCollection('how_it_works_step');
                    }

                    $keptStepIds[] = $step->id;
                }

                /* ================= DELETE REMOVED STEPS ================= */
                HowItWorksStep::where('section_id', $section->id)
                    ->whereNotIn('id', $keptStepIds)
                    ->get()
                    ->each(function ($step) {
                        $step->clearMediaCollection('how_it_works_step');
                        $step->delete();
                    });
            });

            return response()->json(['success' => true]);
        }





// ================ KEY FEATURES =================


        public function keyFeaturesIndex()
        {
            $section = HomeKeyFeatureSection::first()
                ?? HomeKeyFeatureSection::create([]);

            $items = $section->items;

            return view('admin.home.key-features', compact('section', 'items'));
        }

        public function keyFeaturesUpdate(Request $request)
        {
            $section = HomeKeyFeatureSection::first();

            $section->update([
                'heading' => $request->heading,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true]);
        }

        public function keyFeaturesItemStore(Request $request)
        {
            $section = HomeKeyFeatureSection::first();

            if ($section->items()->count() >= 3) {
                return response()->json(['error' => 'Only 3 images allowed'], 422);
            }

            $item = HomeKeyFeatureItem::create([
                'section_id' => $section->id,
                'title' => $request->title,
                'sort_order' => $section->items()->count() + 1,
            ]);

            if ($request->hasFile('image')) {
                $item->addMediaFromRequest('image')
                    ->toMediaCollection('feature_images');
            }

            return response()->json(['success' => true]);
        }

        public function keyFeaturesReorder(Request $request)
        {
            foreach ($request->order as $index => $id) {
                HomeKeyFeatureItem::where('id', $id)
                    ->update(['sort_order' => $index + 1]);
            }

            return response()->json(['success' => true]);
        }

        public function keyFeaturesItemDelete($id)
        {
            $item = HomeKeyFeatureItem::findOrFail($id);
            $item->clearMediaCollection('feature_images');
            $item->delete();

            return response()->json(['success' => true]);
        }








// ================= DOWNLOAD APP SECTION =================

public function downloadAppIndex(Request $request)
{
    // Available pages
    $pages = [
        'home'    => 'home',
        'about'   => 'about',
        'pricing' => 'pricing',
        'contact' => 'contact',
    ];

    // Selected page (default home)
    $pageKey = $request->get('page', 'home');

    // Load section for that page
    $section = DownloadAppSection::where('page_key', $pageKey)->first();

    // All existing sections for sidebar
    $sections = DownloadAppSection::orderBy('page_key')->get()->keyBy('page_key');

    return view('admin.home.download-app-section', compact(
        'pages',
        'pageKey',
        'section',
        'sections'
    ));
}

// public function downloadAppSectionStore(Request $request)
// {
//     $data = $request->validate([
//         'page_key'    => 'required|string|max:50',
//         'title'       => 'nullable|string|max:255',
//         'heading'     => 'nullable|string|max:255',
//         'description' => 'nullable|string',
//         'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//     ]);

//     // ✅ One section per page_key
//     $section = DownloadAppSection::firstOrCreate([
//         'page_key' => $data['page_key']
//     ]);

//     $section->update([
//         'title'       => $data['title'] ?? null,
//         'heading'     => $data['heading'] ?? null,
//         'description' => $data['description'] ?? null,
//         'is_active'   => $request->has('is_active'),
//     ]);

//     // Image via Spatie
//     if ($request->hasFile('image')) {
//         $section
//             ->clearMediaCollection('image')
//             ->addMediaFromRequest('image')
//             ->toMediaCollection('image');
//     }

//     return back()->with('success', 'Download App section saved');
// }

public function downloadAppSectionStore(Request $request)
{
    $data = $request->validate([
        'page_key'    => 'required|string|max:50',
        'title'       => 'nullable|string|max:255',
        'heading'     => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // 🔥 UPSERT (Create OR Update)
    $section = DownloadAppSection::updateOrCreate(
        ['page_key' => $data['page_key']],
        [
            'title'       => $data['title'] ?? null,
            'heading'     => $data['heading'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active'   => $request->boolean('is_active'),
        ]
    );

    // Image (Spatie)
    if ($request->hasFile('image')) {
        $section
            ->clearMediaCollection('image')
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');
    }

    return redirect()
        ->route('admin.home.download-app.index', ['page' => $data['page_key']])
        ->with('success', 'Download App section updated successfully');
}





}
