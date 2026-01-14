<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutWhyPlatformSection;
use App\Models\AboutWhyPlatformContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutWhyPlatformController extends Controller
{
    /**
     * INDEX PAGE
     * Sidebar list + default editor data
     */
    public function index()
    {
        $sections = AboutWhyPlatformSection::with('contents')
                        ->orderBy('sort_order')
                        ->get();

        $section = $sections->first(); // default loaded in editor

        return view('admin.about.why-platform', [
            'sections' => $sections,
            'section'  => $section,
        ]);
    }

    /**
     * STORE / UPDATE SECTION + PARAGRAPHS (SINGLE FORM)
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // ================= SECTION SAVE =================
            $section = AboutWhyPlatformSection::updateOrCreate(
                ['id' => $request->id],
                [
                    'badge'        => $request->badge,
                    'heading'      => $request->heading,
                    'subheading'   => $request->subheading,
                    'closing_text'=> $request->closing_text,
                    'sort_order'   => $request->sort_order ?? 0,
                    'is_active'    => 1,
                ]
            );

            // ================= IMAGE (SPATIE) =================
            if ($request->hasFile('image')) {
                $section->clearMediaCollection('why_platform_image');
                $section->addMediaFromRequest('image')
                        ->toMediaCollection('why_platform_image');
            }

            // ================= PARAGRAPHS =================
            // Delete old paragraphs (simple & safe approach)
            AboutWhyPlatformContent::where('section_id', $section->id)->delete();

            if ($request->has('paragraphs')) {
                foreach ($request->paragraphs as $para) {
                    if (!empty(trim($para['content']))) {
                        AboutWhyPlatformContent::create([
                            'section_id' => $section->id,
                            'content'    => $para['content'],
                            'sort_order' => $para['sort_order'] ?? 0,
                            'is_active'  => 1,
                        ]);
                    }
                }
            }
        });

        return back()->with('success', 'Why Platform section saved successfully');
    }

    /**
     * DELETE SECTION (with paragraphs + media)
     */
    public function deleteSection($id)
    {
        $section = AboutWhyPlatformSection::findOrFail($id);

        // Delete media
        $section->clearMediaCollection('why_platform_image');

        // Delete related paragraphs
        $section->contents()->delete();

        // Delete section
        $section->delete();

        return back()->with('success', 'Section deleted successfully');
    }
}
