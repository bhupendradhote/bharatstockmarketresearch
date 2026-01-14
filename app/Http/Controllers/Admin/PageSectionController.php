<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionController extends Controller
{
    public function index()
    {
        $sections = PageSection::orderBy('page_type')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($section) {
                // Send image URLs to blade for preview
                $section->desktop_image_url = $section->getFirstMediaUrl('desktop');
                $section->mobile_image_url  = $section->getFirstMediaUrl('mobile');
                return $section;
            });

        return view('admin.page-sections.index', compact('sections'));
    }

    /**
     * STORE
     */
   public function store(Request $request)
{
    $data = $request->validate([
        'page_type'     => 'required|string',
        'section_key'   => 'nullable|string',
        'title'         => 'nullable|string',
        'subtitle'      => 'nullable|string',
        'badge'         => 'nullable|string',
        'description'   => 'nullable|string',
        'content'       => 'nullable|string',
        'button_1_text' => 'nullable|string',
        'button_1_link' => 'nullable|string',
        'button_2_text' => 'nullable|string',
        'button_2_link' => 'nullable|string',
        'status'        => 'required|in:0,1,true,false',
    ]);

    $data['status'] = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);

    $section = PageSection::create($data);

    if ($request->hasFile('desktop_image')) {
        $section->addMediaFromRequest('desktop_image')->toMediaCollection('desktop');
    }

    if ($request->hasFile('mobile_image')) {
        $section->addMediaFromRequest('mobile_image')->toMediaCollection('mobile');
    }

    return response()->json(['success' => true]);
}


    /**
     * UPDATE
     */
    public function update(Request $request, PageSection $pageSection)
{
    $data = $request->validate([
        'page_type'     => 'required|string',
        'section_key'   => 'nullable|string',
        'title'         => 'nullable|string',
        'subtitle'      => 'nullable|string',
        'badge'         => 'nullable|string',
        'description'   => 'nullable|string',
        'content'       => 'nullable|string',
        'button_1_text' => 'nullable|string',
        'button_1_link' => 'nullable|string',
        'button_2_text' => 'nullable|string',
        'button_2_link' => 'nullable|string',
        'status'        => 'required|in:0,1,true,false',
    ]);

    $data['status'] = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);

    $pageSection->update($data);

    if ($request->hasFile('desktop_image')) {
        $pageSection->clearMediaCollection('desktop');
        $pageSection->addMediaFromRequest('desktop_image')->toMediaCollection('desktop');
    }

    if ($request->hasFile('mobile_image')) {
        $pageSection->clearMediaCollection('mobile');
        $pageSection->addMediaFromRequest('mobile_image')->toMediaCollection('mobile');
    }

    return response()->json(['success' => true]);
}


    /**
     * DELETE
     */
    public function destroy(PageSection $pageSection)
    {
        $pageSection->clearMediaCollection('desktop');
        $pageSection->clearMediaCollection('mobile');
        $pageSection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully'
        ]);
    }
}
