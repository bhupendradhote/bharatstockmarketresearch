<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    /* =======================
        SHOW PAGE
    ========================*/
    public function index()
    {
        $coupons = Coupon::orderByDesc('id')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /* =======================
        STORE
    ========================*/
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required|in:flat,percent',
            'value' => 'required|numeric|min:1',
            'min_amount' => 'nullable|numeric',
            'per_user_limit' => 'nullable|integer',
            'global_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);

        $data['active'] = true;
        $data['used_global'] = 0;

        return Coupon::create($data);
    }

    /* =======================
        UPDATE
    ========================*/
    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:flat,percent',
            'value' => 'required|numeric',
            'min_amount' => 'nullable|numeric',
            'per_user_limit' => 'nullable|integer',
            'global_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update($data);

        return $coupon;
    }

    /* =======================
        DELETE
    ========================*/
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return response()->json(['success'=>true]);
    }

    /* =======================
        TOGGLE
    ========================*/
    public function toggle(Coupon $coupon)
    {
        $coupon->update(['active'=>!$coupon->active]);
        return response()->json(['active'=>$coupon->active]);
    }
}