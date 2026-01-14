<?php

namespace App\Http\Controllers\Api\About;

use App\Http\Controllers\Controller;
use App\Models\AboutCoreValue;
use App\Models\AboutCoreValueSection;
use Illuminate\Http\Request;

class CoreValueApiController extends Controller
{
    // ===== FETCH CORE VALUES DATA FOR APP =====
    public function index()
    {
        $section = AboutCoreValueSection::with([
            'values' => fn ($q) => $q->where('is_active', 1)->orderBy('sort_order')
        ])->where('is_active', 1)->first();

        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

    // ===== CREATE / UPDATE CORE VALUE SECTION =====
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

        return response()->json([
            'success' => true,
            'message' => 'Section saved',
            'data' => $section
        ]);
    }

    // ===== ADD CORE VALUE ITEM =====
    public function storeValue(Request $request)
    {
        $section = AboutCoreValueSection::firstOrFail();

        $value = AboutCoreValue::create([
            'section_id' => $section->id,
            'icon'       => $request->icon,
            'title'      => $request->title,
            'description'=> $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Value added',
            'data' => $value
        ]);
    }

    // ===== UPDATE CORE VALUE ITEM =====
    public function updateValue(Request $request, $id)
    {
        $value = AboutCoreValue::findOrFail($id);

        $value->update([
            'icon'        => $request->icon,
            'title'       => $request->title,
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Value updated',
            'data' => $value
        ]);
    }

    // ===== DELETE CORE VALUE ITEM =====
    public function deleteValue($id)
    {
        AboutCoreValue::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Value deleted'
        ]);
    }
}
