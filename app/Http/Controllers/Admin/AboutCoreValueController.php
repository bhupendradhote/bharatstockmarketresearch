<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCoreValue;
use App\Models\AboutCoreValueSection;
use Illuminate\Http\Request;

class AboutCoreValueController extends Controller
{
    public function index()
    {
        $section = AboutCoreValueSection::first();

        return view('admin.about.core-values', [
            'section' => $section,
            'values'  => $section
                ? $section->values()->orderBy('sort_order')->get()
                : collect()
        ]);
    }

    // ================= SECTION SAVE =================
    public function storeSection(Request $request)
    {
        $section = AboutCoreValueSection::updateOrCreate(
            ['id' => $request->id],
            [
                'badge'       => $request->badge,
                'title'       => $request->title,
                'subtitle'    => $request->subtitle,
                'description' => $request->description,
                'sort_order'  => 1,
                'is_active'   => 1,
            ]
        );

        return back()->with('success', 'Core values section saved');
    }

    // ================= ADD CORE VALUE =================
    public function storeValue(Request $request)
    {
        // ✅ ENSURE SECTION EXISTS
        $section = AboutCoreValueSection::first();

        if (!$section) {
            $section = AboutCoreValueSection::create([
                'badge'       => 'Core values',
                'title'       => 'Our core values',
                'description' => '',
                'sort_order'  => 1,
                'is_active'   => 1,
            ]);
        }

        AboutCoreValue::create([
            'section_id' => $section->id,   // 🔥 NEVER NULL
            'icon'       => $request->icon,
            'title'      => $request->title,
            'description'=> $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => 1,
        ]);

        return back()->with('success', 'Core value added');
    }

    // ================= UPDATE CORE VALUE =================
    public function updateValue(Request $request, $id)
    {
        AboutCoreValue::findOrFail($id)->update([
            'icon'        => $request->icon,
            'title'       => $request->title,
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Core value updated');
    }

    // ================= DELETE CORE VALUE =================
    public function deleteValue($id)
    {
        AboutCoreValue::findOrFail($id)->delete();

        return back()->with('success', 'Core value deleted');
    }
}
