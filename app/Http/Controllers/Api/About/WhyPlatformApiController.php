<?php

namespace App\Http\Controllers\Api\About;

use App\Http\Controllers\Controller;
use App\Models\AboutWhyPlatformSection;
use App\Models\AboutWhyPlatformContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhyPlatformApiController extends Controller
{
    // ===== FETCH ALL WHY PLATFORM SECTIONS =====
    public function index()
    {
        $sections = AboutWhyPlatformSection::with([
            'contents' => function ($q) {
                $q->where('is_active', 1)->orderBy('sort_order');
            },
            'media'
        ])
        ->where('is_active', 1)
        ->orderBy('sort_order')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $sections
        ]);
    }

    // ===== CREATE NEW WHY PLATFORM SECTION =====
    public function store(Request $request)
    {
        DB::transaction(function () use ($request, &$section) {

            $section = AboutWhyPlatformSection::create([
                'badge'        => $request->badge,
                'heading'      => $request->heading,
                'subheading'   => $request->subheading,
                'closing_text' => $request->closing_text,
                'sort_order'   => $request->sort_order ?? 0,
                'is_active'    => 1,
            ]);

            if ($request->hasFile('image')) {
                $section->addMediaFromRequest('image')
                        ->toMediaCollection('why_platform_image');
            }

            if (is_array($request->paragraphs)) {
                foreach ($request->paragraphs as $para) {
                    if (!empty(trim($para['content'] ?? ''))) {
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

        return response()->json([
            'success' => true,
            'message' => 'Why Platform section created successfully',
            'data' => $section->load('contents', 'media')
        ]);
    }

    // ===== UPDATE EXISTING SECTION + CONTENTS =====
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id, &$section) {

            $section = AboutWhyPlatformSection::findOrFail($id);

            // UPDATE SECTION
            $section->update([
                'badge'        => $request->badge,
                'heading'      => $request->heading,
                'subheading'   => $request->subheading,
                'closing_text' => $request->closing_text,
                'sort_order'   => $request->sort_order ?? $section->sort_order,
            ]);

            // UPDATE IMAGE IF SENT
            if ($request->hasFile('image')) {
                $section->clearMediaCollection('why_platform_image');
                $section->addMediaFromRequest('image')
                        ->toMediaCollection('why_platform_image');
            }

            // REPLACE CONTENTS
            AboutWhyPlatformContent::where('section_id', $section->id)->delete();

            if (is_array($request->paragraphs)) {
                foreach ($request->paragraphs as $para) {
                    if (!empty(trim($para['content'] ?? ''))) {
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

        return response()->json([
            'success' => true,
            'message' => 'Why Platform section updated successfully',
            'data' => $section->load('contents', 'media')
        ]);
    }

    // ===== DELETE SECTION =====
    public function deleteSection($id)
    {
        $section = AboutWhyPlatformSection::findOrFail($id);

        $section->clearMediaCollection('why_platform_image');
        $section->contents()->delete();
        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Why Platform section deleted successfully'
        ]);
    }
}
