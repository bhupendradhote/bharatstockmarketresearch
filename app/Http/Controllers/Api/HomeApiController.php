<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\HomeCounter;
use App\Models\WhyChooseSection;
use App\Models\HowItWorksSection;
use App\Models\HowItWorksStep;
use App\Models\HomeKeyFeatureSection;
use App\Models\HomeKeyFeatureItem;
use App\Models\DownloadAppSection;

class HomeApiController extends Controller
{
    /* ===================== COUNTERS ===================== */

    public function counters()
    {
        return response()->json([
            'success' => true,
            'data' => HomeCounter::orderBy('sort_order')->get()
        ]);
    }

    public function counterStore(Request $request)
    {
        $counter = HomeCounter::create([
            'value' => $request->value,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json(['success' => true, 'data' => $counter]);
    }

    public function counterUpdate(Request $request, $id)
    {
        $counter = HomeCounter::findOrFail($id);

        $counter->update([
            'value' => $request->value,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json(['success' => true]);
    }

    public function counterDelete($id)
    {
        HomeCounter::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function counterToggle($id)
    {
        $counter = HomeCounter::findOrFail($id);
        $counter->update(['is_active' => !$counter->is_active]);

        return response()->json(['success' => true, 'status' => $counter->is_active]);
    }

    public function counterReorder(Request $request)
    {
        foreach ($request->order as $i => $id) {
            HomeCounter::where('id', $id)->update(['sort_order' => $i + 1]);
        }

        return response()->json(['success' => true]);
    }

    /* ===================== WHY CHOOSE ===================== */

    public function whyChoose()
    {
        return response()->json([
            'success' => true,
            'data' => WhyChooseSection::orderBy('sort_order')->get()
        ]);
    }

    public function whyChooseSave(Request $request)
{
    $section = WhyChooseSection::first();

    if ($section) {
        // UPDATE
        $section->update([
            'title'       => $request->title,
            'badge'       => $request->badge,
            'heading'     => $request->heading,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);
    } else {
        // CREATE
        $section = WhyChooseSection::create([
            'title'       => $request->title,
            'badge'       => $request->badge,
            'heading'     => $request->heading,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);
    }

    // IMAGE HANDLE (SAME FOR BOTH)
    if ($request->hasFile('image')) {
        $section->clearMediaCollection('why_choose_image');
        $section
            ->addMediaFromRequest('image')
            ->toMediaCollection('why_choose_image');
    }

    return response()->json([
        'success' => true,
        'message' => 'Why Choose section saved successfully',
        'data' => $section
    ]);
}


    public function whyChooseDelete($id)
    {
        $section = WhyChooseSection::findOrFail($id);
        $section->clearMediaCollection('why_choose_image');
        $section->delete();

        return response()->json(['success' => true]);
    }

    public function whyChooseToggle($id)
    {
        $section = WhyChooseSection::findOrFail($id);
        $section->update(['is_active' => !$section->is_active]);

        return response()->json(['success' => true]);
    }

    public function whyChooseReorder(Request $request)
    {
        foreach ($request->order as $i => $id) {
            WhyChooseSection::where('id', $id)->update(['sort_order' => $i + 1]);
        }

        return response()->json(['success' => true]);
    }

    /* ===================== HOW IT WORKS ===================== */

    public function howItWorks()
    {
        return response()->json([
            'success' => true,
            'data' => HowItWorksSection::with('steps')->get()
        ]);
    }

    public function howItWorksSave(Request $request)
    {
        DB::transaction(function () use ($request) {

            $sectionData = json_decode($request->section, true);

            $section = HowItWorksSection::updateOrCreate(
                ['id' => $sectionData['id'] ?? null],
                $sectionData
            );

            $keep = [];

            foreach ($request->steps as $i => $stepData) {
                $step = HowItWorksStep::firstOrNew(['id' => $stepData['id'] ?? null]);

                $step->section_id = $section->id;
                $step->title = $stepData['title'];
                $step->description = $stepData['description'] ?? '';
                $step->is_active = $stepData['is_active'] ?? false;
                $step->sort_order = $i + 1;
                $step->save();

                if ($request->hasFile("steps.$i.image")) {
                    $step->clearMediaCollection('how_it_works_step');
                    $step->addMediaFromRequest("steps.$i.image")
                        ->toMediaCollection('how_it_works_step');
                }

                $keep[] = $step->id;
            }

            HowItWorksStep::where('section_id', $section->id)
                ->whereNotIn('id', $keep)
                ->delete();
        });

        return response()->json(['success' => true]);
    }

    /* ===================== KEY FEATURES ===================== */

    public function keyFeatures()
    {
        $section = HomeKeyFeatureSection::first();

        return response()->json([
            'success' => true,
            'section' => $section,
            'items' => $section?->items ?? []
        ]);
    }

    public function keyFeatureUpdate(Request $request)
    {
        $section = HomeKeyFeatureSection::first();
        $section->update($request->only('heading', 'description'));

        return response()->json(['success' => true]);
    }

    public function keyFeatureItemStore(Request $request)
{
    $section = HomeKeyFeatureSection::first();

    $currentCount = $section->items()->count();

    // ❌ Max 3 items allowed
    if ($currentCount >= 3) {
        return response()->json([
            'success' => false,
            'message' => 'Only 3 key feature items are allowed'
        ], 422);
    }

    // ➕ Create item
    $item = HomeKeyFeatureItem::create([
        'section_id' => $section->id,
        'title'      => $request->title,
        'sort_order' => $currentCount + 1,
    ]);

    if ($request->hasFile('image')) {
        $item->addMediaFromRequest('image')
            ->toMediaCollection('feature_images');
    }

    // 🔒 Min 3 items validation
    $totalCount = $section->items()->count();

    if ($totalCount < 3) {
        return response()->json([
            'success' => false,
            'message' => 'Please add minimum 3 key feature items'
        ], 422);
    }

    return response()->json([
        'success' => true,
        'message' => '3 key feature items stored successfully'
    ]);
}


    public function keyFeatureItemDelete($id)
    {
        $item = HomeKeyFeatureItem::findOrFail($id);
        $item->clearMediaCollection('feature_images');
        $item->delete();

        return response()->json(['success' => true]);
    }

    public function keyFeatureReorder(Request $request)
    {
        foreach ($request->order as $i => $id) {
            HomeKeyFeatureItem::where('id', $id)->update(['sort_order' => $i + 1]);
        }

        return response()->json(['success' => true]);
    }

    /* ===================== DOWNLOAD APP ===================== */

    public function downloadApp($page_key)
    {
        return response()->json([
            'success' => true,
            'data' => DownloadAppSection::where('page_key', $page_key)->first()
        ]);
    }

   public function downloadAppStore(Request $request)
{
    // Find existing section by page_key
    $section = DownloadAppSection::where('page_key', $request->page_key)->first();

    if ($section) {
        // UPDATE
        $section->update([
            'title'       => $request->title,
            'heading'     => $request->heading,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);
    } else {
        // CREATE
        $section = DownloadAppSection::create([
            'page_key'    => $request->page_key,
            'title'       => $request->title,
            'heading'     => $request->heading,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);
    }

    // IMAGE HANDLE (COMMON FOR BOTH)
    if ($request->hasFile('image')) {
        $section->clearMediaCollection('image');
        $section->addMediaFromRequest('image')
            ->toMediaCollection('image');
    }

    return response()->json([
        'success' => true,
        'message' => 'Download App section saved successfully',
        'data' => $section
    ]);
}

}
