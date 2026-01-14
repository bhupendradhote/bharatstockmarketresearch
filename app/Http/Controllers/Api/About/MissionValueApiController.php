<?php

namespace App\Http\Controllers\Api\About;

use App\Http\Controllers\Controller;
use App\Models\AboutMissionValue;
use Illuminate\Http\Request;

class MissionValueApiController extends Controller
{
    // ===== FETCH SINGLE MISSION =====
    public function show()
    {
        return response()->json([
            'success' => true,
            'data' => AboutMissionValue::first()
        ]);
    }

    // ===== CREATE IF NOT EXISTS / UPDATE IF EXISTS =====
    public function storeOrUpdate(Request $request)
    {
        $mission = AboutMissionValue::first();

        if ($mission) {
            $mission->update([
                'badge'             => $request->badge,
                'title'             => $request->title,
                'mission_text'      => $request->mission_text,
                'short_description' => $request->short_description,
                'is_active'         => $request->is_active ?? 1,
            ]);
        } else {
            $mission = AboutMissionValue::create([
                'badge'             => $request->badge,
                'title'             => $request->title,
                'mission_text'      => $request->mission_text,
                'short_description' => $request->short_description,
                'is_active'         => $request->is_active ?? 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mission saved successfully',
            'data' => $mission
        ]);
    }

    // ===== DELETE SINGLE MISSION =====
    public function delete()
    {
        $mission = AboutMissionValue::first();

        if ($mission) {
            $mission->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Mission deleted successfully'
        ]);
    }
}
