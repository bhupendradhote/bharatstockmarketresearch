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
use App\Models\RiskRewardMaster;

class TipController extends Controller
{
public function index(Request $request)
{
    $query = Tip::with(['category', 'planAccess.plan'])
        ->where('status', '!=', 'archived');

    if ($request->filled('search')) {
        $query->where('stock_name', 'like', '%' . $request->search . '%');
    }
    
    if ($request->filled('trade_status')) {
        $query->where('trade_status', $request->trade_status);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }
    if ($request->filled('month')) {
        $query->whereMonth('created_at', $request->month);
    }
    if ($request->filled('year')) {
        $query->whereYear('created_at', $request->year);
    }

    $tips = $query->orderByRaw("FIELD(trade_status, 'Open', 'Closed')")
                  ->latest()
                  ->paginate(10)
                  ->withQueryString();

    return view('admin.tips.index', compact('tips'));
}

    public function EquityTips()
    {
        $categories = TipCategory::where('status', 1)->get();
        $plans = ServicePlan::where('status', 1)->get();
        $riskMaster = RiskRewardMaster::where('is_active', 1)->first();

        $tips = Tip::with(['category', 'planAccess.plan'])
            ->where('tip_type', 'equity')
            ->where('status', '!=', 'archived')
            ->orderByRaw("FIELD(trade_status, 'Open', 'Closed')")
            ->latest()
            ->paginate(20);

        return view('admin.tips.tips', compact('tips', 'categories', 'plans', 'riskMaster'));
    }

    public function FutureAndOption()
    {
        $categories = TipCategory::where('status', 1)->get();
        $plans = ServicePlan::where('status', 1)->get();
        $riskMaster = RiskRewardMaster::where('is_active', 1)->first();

        $tips = Tip::with(['category', 'planAccess.plan'])
            ->whereIn('tip_type', ['future', 'option'])
            ->where('status', '!=', 'archived')
            ->orderByRaw("FIELD(trade_status, 'Open', 'Closed')")
            ->latest()
            ->paginate(20);

        return view('admin.tips.future_Option', compact('tips', 'categories', 'plans', 'riskMaster'));
    }

    // --- STORE METHODS ---

    public function storeEquityTip(Request $request)
    {
        return $this->handleStore($request, 'equity');
    }

    public function storeDerivativeTip(Request $request)
    {
        return $this->handleStore($request, $request->tip_type);
    }

    private function handleStore(Request $request, $type)
    {
        $rules = [
            'stock_name'     => 'required|string|max:255',
            'symbol_token'   => 'nullable|string|max:100',
            'category_id'    => 'required|exists:tip_categories,id',
            'exchange'       => 'required|in:NSE,BSE,MCX',
            'call_type'      => 'required|in:Buy,Sell',
            'entry_price'    => 'required|numeric',
            'target_price'   => 'required|numeric',
            'stop_loss'      => 'required|numeric',
            'plans'          => 'required|array|min:1',
        ];

        if ($type === 'option') {
            $rules['option_type']  = 'required|in:CE,PE';
            $rules['strike_price'] = 'required|numeric';
            $rules['expiry_date']  = 'required|date';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $tip = Tip::create([
                'tip_type'       => $type,
                'stock_name'     => strtoupper($request->stock_name),
                'symbol_token'   => $request->symbol_token,
                'exchange'       => $request->exchange,
                'call_type'      => $request->call_type,
                'category_id'    => $request->category_id,
                'entry_price'    => $request->entry_price,
                'target_price'   => $request->target_price,
                'target_price_2' => $request->target_price_2,
                'stop_loss'      => $request->stop_loss,
                'cmp_price'      => $request->cmp_price ?? $request->entry_price,
                
                'expiry_date'    => $request->expiry_date ?? null,
                'strike_price'   => $request->strike_price ?? null,
                'option_type'    => $request->option_type ?? null,

                'status'         => 'Active',
                'trade_status'   => 'Open', // Explicitly set Open
                'admin_note'     => $request->admin_note ?? "New $type Tip Generated",
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
            return redirect()->back()->with('success', ucfirst($type) . ' Tip published successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function create()
    {
        $plans = ServicePlan::where('status', 1)->orderBy('sort_order')->get();
        $categories = TipCategory::where('status', 1)->orderBy('name')->get();
        return view('admin.tips.create', compact('plans', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_name'   => 'required|string|max:255',
            'symbol_token' => 'nullable|string|max:100',
            'exchange'     => 'required|in:NSE,BSE',
            'call_type'    => 'required|in:BUY,SELL',
            'category_id'  => 'required|exists:tip_categories,id',
            'entry_price'  => 'required|numeric',
            'target_price' => 'required|numeric',
            'stop_loss'    => 'required|numeric',
            'status'       => 'required|string',
            'plan_access'  => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $tip = Tip::create([
                'stock_name'   => strtoupper($request->stock_name),
                'symbol_token' => $request->symbol_token,
                'exchange'     => $request->exchange,
                'call_type'    => $request->call_type,
                'category_id'  => $request->category_id,
                'entry_price'  => $request->entry_price,
                'target_price' => $request->target_price,
                'stop_loss'    => $request->stop_loss,
                'status'       => $request->status,
                'trade_status' => 'Open',
                'admin_note'   => $request->admin_note,
                'created_by'   => auth()->id(),
            ]);

            foreach ($request->plan_access as $access) {
                [$planId, $durationId] = explode('_', $access);
                TipPlanAccess::create([
                    'tip_id'                 => $tip->id,
                    'service_plan_id'        => $planId,
                    'service_plan_duration_id' => $durationId,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.tips.index')->with('success', 'Market Tip Created Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function updateLiveStatus(Request $request, $id)
    {
        $request->validate([
            'status'    => 'required|in:T1-Achieved,T2-Achieved,SL-Hit',
            'cmp_price' => 'required|numeric'
        ]);

        $tip = Tip::findOrFail($id);


        if ($tip->trade_status === 'Closed') {
            return response()->json([
                'success'      => true,
                'message'      => 'Trade is closed. No updates allowed.',
                'new_status'   => $tip->status,
                'trade_status' => 'Closed'
            ]);
        }

        $newStatus = $request->status;
        $tradeStatus = 'Open'; // Default assumption

        if ($newStatus === 'SL-Hit' || $newStatus === 'T2-Achieved') {
            $tradeStatus = 'Closed';
        } 
        elseif ($newStatus === 'T1-Achieved') {
            if (empty($tip->target_price_2) || $tip->target_price_2 == 0) {
                $tradeStatus = 'Closed';
            } else {
                $tradeStatus = 'Open';
            }
        }

        $tip->update([
            'status'       => $newStatus,
            'trade_status' => $tradeStatus,
            'cmp_price'    => $request->cmp_price,
            'admin_note'   => $tip->admin_note . "\n[System]: Status changed to $newStatus at price " . $request->cmp_price
        ]);

        return response()->json([
            'success'      => true,
            'new_status'   => $newStatus,
            'trade_status' => $tradeStatus
        ]);
    }

    // --- HELPERS ---

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:tip_categories,name']);
        TipCategory::create(['name' => $request->name, 'status' => 1]);
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function edit(Tip $tip)
    {
        if ($tip->status == 'archived') abort(403);
        $categories = TipCategory::all();
        $plans = ServicePlan::all();
        return view('admin.tips.edit', compact('tip', 'categories', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $oldTip = Tip::findOrFail($id);
        
        $validatedData = $request->validate([
            'stock_name' => 'required',
            'plans' => 'required|array'
        ]);

        DB::transaction(function () use ($oldTip, $request) {
            $oldTip->update(['status' => 'archived']);
            $planIds = $request->plans;

            $newTip = $oldTip->replicate();
            $newTip->fill($request->except(['plans', '_token', '_method']));
            $newTip->parent_id = $oldTip->parent_id ?? $oldTip->id;
            $newTip->version = $oldTip->version + 1;
            $newTip->status = 'Active';
            $newTip->trade_status = 'Open'; // Reset to Open for new version
            $newTip->created_by = Auth::id();
            $newTip->save();

            foreach ($planIds as $planId) {
                TipPlanAccess::create(['tip_id' => $newTip->id, 'service_plan_id' => $planId]);
            }
        });

        return redirect()->route('admin.tips.index')->with('success', 'Tip updated successfully.');
    }

    public function storeFollowUp(Request $request, $id)
    {
        $request->validate([
            'target_price' => 'required|numeric',
            'target_price_2' => 'nullable|numeric',
            'stop_loss' => 'required|numeric',
            'message' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();
            
            $tip = Tip::findOrFail($id);

            $newEntry = [
                'date' => now()->toDateTimeString(),
                'message' => $request->message,
                'old_values' => [
                    'target_price' => $tip->target_price,
                    'target_price_2' => $tip->target_price_2,
                    'stop_loss' => $tip->stop_loss,
                ],
                'new_values' => [
                    'target_price' => $request->target_price,
                    'target_price_2' => $request->target_price_2,
                    'stop_loss' => $request->stop_loss,
                ]
            ];

            $currentFollowups = $tip->followups ?? [];
            array_unshift($currentFollowups, $newEntry); 

            $tip->update([
                'target_price' => $request->target_price,
                'target_price_2' => $request->target_price_2,
                'stop_loss' => $request->stop_loss,
                'followups' => $currentFollowups
            ]);

            DB::commit();
            
            return redirect()->back()->with('success', 'Follow-up added and prices updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}