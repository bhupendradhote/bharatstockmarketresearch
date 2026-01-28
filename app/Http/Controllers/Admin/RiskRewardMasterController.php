<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiskRewardMaster;
use Illuminate\Http\Request;

class RiskRewardMasterController extends Controller
{
    /**
     * Show risk reward master list & form
     */
    public function index()
    {
        $masters = RiskRewardMaster::orderByDesc('id')->get();
        $activeMaster = RiskRewardMaster::getActive();

        return view('admin.tips.risk_reward_master', compact('masters', 'activeMaster'));
    }

    /**
     * Store new master
     */
    public function store(Request $request)
    {
        $request->validate([
            'calculation_type' => 'required|in:percentage,price',
            'target1_value'    => 'required|numeric|min:0',
            'target2_value'    => 'nullable|numeric|min:0',
            'stoploss_value'   => 'required|numeric|min:0',
        ]);

        $master = RiskRewardMaster::create([
            'calculation_type' => $request->calculation_type,
            'target1_value'    => $request->target1_value,
            'target2_value'    => $request->target2_value,
            'stoploss_value'   => $request->stoploss_value,
            'is_active'        => false,
        ]);

        return redirect()->back()->with('success', 'Risk Reward Master created successfully.');
    }

    /**
     * Activate master (only one active)
     */
    public function activate(RiskRewardMaster $riskRewardMaster)
    {
        $riskRewardMaster->activate();

        return redirect()->back()->with('success', 'Selected master is now ACTIVE.');
    }
}
