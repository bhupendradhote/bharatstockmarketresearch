<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionApiController extends Controller
{
    // ================= FETCH SECTIONS BY PAGE KEY =================
    public function index($page_key)
    {
        $sections = PageSection::where('page_type', $page_key)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($section) {
                return [
                    'id' => $section->id,
                    'page_key' => $section->page_type,
                    'section_key' => $section->section_key,
                    'title' => $section->title,
                    'subtitle' => $section->subtitle,
                    'badge' => $section->badge,
                    'description' => $section->description,
                    'content' => $section->content,
                    'button_1_text' => $section->button_1_text,
                    'button_1_link' => $section->button_1_link,
                    'button_2_text' => $section->button_2_text,
                    'button_2_link' => $section->button_2_link,
                    'desktop_image' => $section->getFirstMediaUrl('desktop'),
                    'mobile_image' => $section->getFirstMediaUrl('mobile'),
                ];
            });

        return response()->json([
            'success' => true,
            'page_key' => $page_key,
            'data' => $sections
        ]);
    }

    // ================= CREATE OR UPDATE SECTION =================
    public function store(Request $request)
    {
        $data = $request->validate([
            'page_key'     => 'required|string|max:100',
            'section_key'  => 'required|string|max:100',
            'title'        => 'nullable|string',
            'subtitle'     => 'nullable|string',
            'badge'        => 'nullable|string',
            'description'  => 'nullable|string',
            'content'      => 'nullable|string',
            'button_1_text'=> 'nullable|string',
            'button_1_link'=> 'nullable|string',
            'button_2_text'=> 'nullable|string',
            'button_2_link'=> 'nullable|string',
            'sort_order'   => 'nullable|integer',
            'status'       => 'required|boolean',
        ]);

        // 🔒 Create or update by page_key + section_key
        $section = PageSection::updateOrCreate(
            [
                'page_type'   => $data['page_key'],
                'section_key' => $data['section_key'],
            ],
            [
                'title'         => $data['title'] ?? null,
                'subtitle'      => $data['subtitle'] ?? null,
                'badge'         => $data['badge'] ?? null,
                'description'   => $data['description'] ?? null,
                'content'       => $data['content'] ?? null,
                'button_1_text' => $data['button_1_text'] ?? null,
                'button_1_link' => $data['button_1_link'] ?? null,
                'button_2_text' => $data['button_2_text'] ?? null,
                'button_2_link' => $data['button_2_link'] ?? null,
                'sort_order'    => $data['sort_order'] ?? 0,
                'status'        => $data['status'],
            ]
        );

        // Desktop image
        if ($request->hasFile('desktop_image')) {
            $section->clearMediaCollection('desktop');
            $section->addMediaFromRequest('desktop_image')
                ->toMediaCollection('desktop');
        }

        // Mobile image
        if ($request->hasFile('mobile_image')) {
            $section->clearMediaCollection('mobile');
            $section->addMediaFromRequest('mobile_image')
                ->toMediaCollection('mobile');
        }

        return response()->json([
            'success' => true,
            'message' => 'Page section saved successfully',
            'data' => [
                'id' => $section->id,
                'page_key' => $section->page_type,
                'section_key' => $section->section_key
            ]
        ]);
    }

    // ================= DELETE SECTION =================
    public function destroy($id)
    {
        $section = PageSection::findOrFail($id);

        $section->clearMediaCollection('desktop');
        $section->clearMediaCollection('mobile');
        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully'
        ]);
    }
}
