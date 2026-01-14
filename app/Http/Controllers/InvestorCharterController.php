<?php

namespace App\Http\Controllers;

use App\Models\InvestorCharterPolicy;

class InvestorCharterController extends Controller
{
    /**
     * Display active Investor Charter
     */
    public function show()
    {
        $policy = InvestorCharterPolicy::with(['pages' => function ($q) {
            $q->where('is_visible', true)
              ->orderBy('page_order');
        }])->where('is_active', true)->firstOrFail();

        return view('investor_charter', compact('policy'));
    }
}
