<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:1',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $coupon = Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'type' => $request->type,
            'value' => $request->value,
            'min_spend' => $request->min_spend ?? 0,
            'max_discount' => $request->max_discount,
            'expires_at' => $request->expires_at,
            'usage_limit' => $request->usage_limit,
            'used_count' => 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('coupon_created', "Created privilege coupon code '{$coupon->code}'", $coupon);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' forged.");
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:1',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $coupon->update([
            'code' => strtoupper(trim($request->code)),
            'type' => $request->type,
            'value' => $request->value,
            'min_spend' => $request->min_spend ?? 0,
            'max_discount' => $request->max_discount,
            'expires_at' => $request->expires_at,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('coupon_updated', "Updated privilege coupon '{$coupon->code}'", $coupon);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' updated.");
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $code = $coupon->code;
        $coupon->delete();

        ActivityLog::record('coupon_deleted', "Deleted coupon '{$code}'");

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$code}' revoked.");
    }
}
