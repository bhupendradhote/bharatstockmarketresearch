<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use App\Models\TipCategory;
use App\Models\TipPlanAccess;
use App\Models\ServicePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TipController extends Controller
{
    public function index()
    {
        $tips = \App\Models\Tip::with([
            'category',
            'planAccess.plan',
            'planAccess.duration'
        ])
            ->latest()
            ->paginate(5);

        return view('admin.tips.index', compact('tips'));
    }

    public function EquityTips()
    {
        $categories = \App\Models\TipCategory::where('status', 1)->get();
        $plans = \App\Models\ServicePlan::where('status', 1)->get();

        $tips = \App\Models\Tip::with([
            'category',
            'planAccess.plan',
            'planAccess.duration'
        ])
            ->where('tip_type', 'equity')
            ->latest()
            ->paginate(20);

        return view('admin.tips.tips', compact('tips', 'categories', 'plans'));
    }

    /**
     * Store function specifically for Equity Cash Tips
     */
    public function storeEquityTip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stock_name'     => 'required|string|max:255',
            'symbol_token'   => 'nullable|string|max:100', // Added Validation
            'category_id'    => 'required|exists:tip_categories,id',
            'exchange'       => 'required|in:NSE,BSE',
            'call_type'      => 'required|in:Buy,Sell',
            'entry_price'    => 'required|numeric',
            'target_price'   => 'required|numeric',
            'target_price_2' => 'nullable|numeric',
            'stop_loss'      => 'required|numeric',
            'cmp_price'      => 'nullable|numeric',
            'plans'          => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $tip = Tip::create([
                'tip_type'       => 'equity',
                'stock_name'     => strtoupper($request->stock_name),
                'symbol_token'   => $request->symbol_token, // Saving Token
                'exchange'       => $request->exchange,
                'call_type'      => $request->call_type,
                'category_id'    => $request->category_id,
                'entry_price'    => $request->entry_price,
                'target_price'   => $request->target_price,
                'target_price_2' => $request->target_price_2,
                'stop_loss'      => $request->stop_loss,
                'cmp_price'      => $request->cmp_price ?? $request->entry_price,
                'status'         => 'Active',
                'admin_note'     => $request->admin_note ?? 'New Equity Tip Generated',
                'created_by'     => Auth::id(),
            ]);

            if ($request->has('plans')) {
                foreach ($request->plans as $planId) {
                    TipPlanAccess::create([
                        'tip_id'          => $tip->id,
                        'service_plan_id' => $planId,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Equity Tip has been published successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to save tip: ' . $e->getMessage())->withInput();
        }
    }


    public function FutureAndOption()
    {
        $categories = \App\Models\TipCategory::where('status', 1)->get();
        $plans = \App\Models\ServicePlan::where('status', 1)->get();

        $tips = \App\Models\Tip::with(['category', 'planAccess.plan'])
            ->whereIn('tip_type', ['future', 'option'])
            ->latest()
            ->paginate(20);

        return view('admin.tips.future_Option', compact('tips', 'categories', 'plans'));
    }


    public function storeDerivativeTip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tip_type'       => 'required|in:future,option',
            'stock_name'     => 'required|string|max:255',
            'symbol_token'   => 'nullable|string|max:100', // Added Validation
            'category_id'    => 'required|exists:tip_categories,id',
            'exchange'       => 'required|in:NSE,MCX',
            'call_type'      => 'required|in:Buy,Sell',
            'entry_price'    => 'required|numeric',
            'target_price'   => 'required|numeric',
            'stop_loss'      => 'required|numeric',
            'cmp_price'      => 'nullable|numeric',
            'plans'          => 'required|array|min:1',
            
            // Conditional validation for Options
            'option_type'    => 'required_if:tip_type,option|nullable|in:CE,PE',
            'strike_price'   => 'required_if:tip_type,option|nullable|numeric',
            'expiry_date'    => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // 1. Create the Tip
            $tip = Tip::create([
                'tip_type'     => $request->tip_type, // 'future' or 'option'
                'stock_name'   => strtoupper($request->stock_name),
                'symbol_token' => $request->symbol_token, // Saving Token
                'exchange'     => $request->exchange,
                'call_type'    => $request->call_type,
                'category_id'  => $request->category_id,
                'entry_price'  => $request->entry_price,
                'target_price' => $request->target_price,
                'target_price_2' => $request->target_price_2,
                'stop_loss'    => $request->stop_loss,
                'cmp_price'    => $request->cmp_price ?? $request->entry_price,
                
                // Derivative specific fields
                'expiry_date'  => $request->expiry_date,
                'strike_price' => $request->tip_type === 'option' ? $request->strike_price : null,
                'option_type'  => $request->tip_type === 'option' ? $request->option_type : null,
                
                'status'       => 'Active',
                'admin_note'   => $request->admin_note ?? "New " . ucfirst($request->tip_type) . " Tip Generated",
                'created_by'   => Auth::id(),
            ]);

            // 2. Map Visibility Plans
            if ($request->has('plans')) {
                foreach ($request->plans as $planId) {
                    TipPlanAccess::create([
                        'tip_id'          => $tip->id,
                        'service_plan_id' => $planId,
                    ]);
                }
            }

            DB::commit();
            
            $msg = ucfirst($request->tip_type) . " Tip has been published successfully!";
            return redirect()->back()->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to save tip: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show create tip page
     */
    public function create()
    {
        $plans = ServicePlan::with('durations')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $categories = TipCategory::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.tips.create', compact('plans', 'categories'));
    }

    /**
     * Store market tip (Generic)
     */
    public function store(Request $request)
    {
        $request->validate([
            'stock_name'   => 'required|string|max:255',
            'symbol_token' => 'nullable|string|max:100', // Added Validation
            'exchange'     => 'required|in:NSE,BSE',
            'call_type'    => 'required|in:BUY,SELL',
            'category_id'  => 'required|exists:tip_categories,id',

            'entry_price'  => 'required|numeric',
            'target_price' => 'required|numeric',
            'stop_loss'    => 'required|numeric',
            'cmp_price'    => 'nullable|numeric',

            'status'       => 'required|string',
            'plan_access'  => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ Create Tip
            $tip = Tip::create([
                'stock_name'   => strtoupper($request->stock_name),
                'symbol_token' => $request->symbol_token, // Saving Token
                'exchange'     => $request->exchange,
                'call_type'    => $request->call_type,
                'category_id'  => $request->category_id,

                'entry_price'  => $request->entry_price,
                'target_price' => $request->target_price,
                'stop_loss'    => $request->stop_loss,
                'cmp_price'    => $request->cmp_price,

                'status'       => $request->status,
                'admin_note'   => $request->admin_note,
                'created_by'   => auth()->id(),
            ]);

            // 2️⃣ Save Plan + Duration Access
            foreach ($request->plan_access as $access) {
                // format: planId_durationId
                [$planId, $durationId] = explode('_', $access);

                TipPlanAccess::create([
                    'tip_id'                 => $tip->id,
                    'service_plan_id'        => $planId,
                    'service_plan_duration_id' => $durationId,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.tips.index')
                ->with('success', 'Market Tip Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with(
                'error',
                'Error creating tip: ' . $e->getMessage()
            );
        }
    }

    /**
     * Store category from modal
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tip_categories,name'
        ]);

        TipCategory::create([
            'name'   => $request->name,
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Category created successfully');
    }
    
       public function edit(Tip $tip)
    {
        if ($tip->status !== 'active') {
            abort(403, 'Archived tips cannot be edited.');
        }
        $categories = TipCategory::all();
        $plans = ServicePlan::all();

        return view('admin.tips.edit', compact('tip','categories','plans'));
    }




    public function update(Request $request, $id)
    {
        // 1. Find the existing tip
        $oldTip = Tip::findOrFail($id);

        // 2. Validate the request
        $validatedData = $request->validate([
            'tip_type'       => 'required|in:equity,future,option',
            'stock_name'     => 'required|string|max:255',
            'symbol_token'   => 'nullable|string|max:100', // Added Validation
            'exchange'       => 'required|string',
            'call_type'      => 'required|string',
            'category_id'    => 'required|exists:tip_categories,id',
            'entry_price'    => 'required|numeric',
            'target_price'   => 'required|numeric',
            'target_price_2' => 'nullable|numeric',
            'stop_loss'      => 'required|numeric',
            'cmp_price'      => 'nullable|numeric',
            'expiry_date'    => 'nullable|date',
            'strike_price'   => 'nullable|numeric',
            'option_type'    => 'nullable|string',
            'admin_note'     => 'nullable|string',
            'plans'          => 'required|array',
        ]);

        try {
            return DB::transaction(function () use ($oldTip, $validatedData) {
                
                $oldTip->update(['status' => 'archived']);

                $planIds = $validatedData['plans'];
                unset($validatedData['plans']); 

                $parentId = $oldTip->parent_id ?? $oldTip->id;

                $newTipData = array_merge($validatedData, [
                    'parent_id'  => $parentId,
                    'version'    => $oldTip->version + 1,
                    'status'     => 'active',
                    'created_by' => auth()->id(),
                ]);

                // 6. Create the new Tip record
                $newTip = Tip::create($newTipData);

                // 7. Create new Plan Access records
                foreach ($planIds as $planId) {
                    TipPlanAccess::create([
                        'tip_id'          => $newTip->id,
                        'service_plan_id' => $planId,
                    ]);
                }

                return redirect()->route('admin.tips.index')
                    ->with('success', "Tip updated to v{$newTip->version} successfully.");
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating tip: ' . $e->getMessage());
        }
    }
}