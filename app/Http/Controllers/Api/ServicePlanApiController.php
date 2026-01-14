<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServicePlan;
use App\Models\ServicePlanDuration;
use App\Models\ServicePlanFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicePlanApiController extends Controller
{
    // ===================================================
    // GET ALL SERVICE PLANS
    // ===================================================
    public function index(Request $request)
    {
        $plans = ServicePlan::with('durations.features')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $plans
        ]);
    }

    // ===================================================
    // GET SINGLE PLAN
    // ===================================================
    public function show($id)
    {
        $plan = ServicePlan::with('durations.features')->find($id);

        if (!$plan) {
            return response()->json([
                'status' => false,
                'message' => 'Service plan not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $plan
        ]);
    }

    // ===================================================
    // CREATE PLAN
    // ===================================================
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1️⃣ Create Plan
            $plan = ServicePlan::create([
                'name'        => $request->name,
                'tagline'     => $request->tagline,
                'featured'    => $request->featured ? 1 : 0,
                'status'      => $request->status ? 1 : 0,
                'sort_order'  => $request->sort_order ?? 1,
                'button_text' => $request->button_text ?? 'Subscribe Now',
            ]);

            // 2️⃣ Create Durations + Features
            foreach ($request->plans ?? [] as $data) {

                $duration = ServicePlanDuration::create([
                    'service_plan_id' => $plan->id,
                    'duration' => $data['duration'],
                    'price' => $data['price'],
                ]);

                foreach ($data['features'] ?? [] as $feat) {
                    ServicePlanFeature::create([
                        'service_plan_duration_id' => $duration->id,
                        'svg_icon' => $feat['svg'] ?? null,
                        'text'     => $feat['text'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Service Plan Created Successfully',
                'data' => $plan->load('durations.features')
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ===================================================
    // UPDATE PLAN
    // ===================================================
    public function update(Request $request, $id)
    {
        $plan = ServicePlan::find($id);

        if (!$plan) {
            return response()->json([
                'status' => false,
                'message' => 'Service plan not found'
            ], 404);
        }

        // 1️⃣ Update main plan
        $plan->update([
            'name'        => $request->name,
            'tagline'     => $request->tagline,
            'featured'    => $request->featured ? 1 : 0,
            'status'      => $request->status ? 1 : 0,
            'sort_order'  => $request->sort_order,
            'button_text' => $request->button_text,
        ]);

        // 2️⃣ Remove old durations & features
        $plan->durations()->each(function ($d) {
            $d->features()->delete();
        });
        $plan->durations()->delete();

        // 3️⃣ Add new durations + features
        foreach ($request->plans ?? [] as $data) {

            $duration = ServicePlanDuration::create([
                'service_plan_id' => $plan->id,
                'duration' => $data['duration'],
                'price' => $data['price'],
            ]);

            foreach ($data['features'] ?? [] as $feat) {
                ServicePlanFeature::create([
                    'service_plan_duration_id' => $duration->id,
                    'svg_icon' => $feat['svg'] ?? '',
                    'text' => $feat['text'] ?? '',
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Service Plan updated successfully',
            'data' => $plan->load('durations.features')
        ]);
    }

    // ===================================================
    // DELETE PLAN
    // ===================================================
    public function destroy($id)
    {
        $plan = ServicePlan::find($id);

        if (!$plan) {
            return response()->json([
                'status' => false,
                'message' => 'Service plan not found'
            ], 404);
        }

        $plan->durations()->each(function ($d) {
            $d->features()->delete();
        });

        $plan->durations()->delete();
        $plan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service plan deleted successfully'
        ]);
    }

    // ===================================================
    // MULTI DELETE
    // ===================================================
    public function multiDelete(Request $request)
    {
        foreach ($request->ids ?? [] as $id) {
            $plan = ServicePlan::find($id);

            if ($plan) {
                $plan->durations()->each(function ($d) {
                    $d->features()->delete();
                });
                $plan->durations()->delete();
                $plan->delete();
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected service plans deleted successfully'
        ]);
    }
}
