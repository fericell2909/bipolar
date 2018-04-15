<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CouponNewRequest;
use App\Models\Coupon;
use App\Models\CouponType;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderByDesc('id')->with('type')->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $types = CouponType::all()->pluck('name', 'id')->toArray();

        return view('admin.coupons.create', compact('types'));
    }

    public function store(CouponNewRequest $request)
    {
        $coupon = new Coupon;
        $coupon->code = $request->input('code');
        $coupon->type_id = $request->input('coupon_type');
        $coupon->amount = $request->input('amount');
        $coupon->frequency = $request->input('limit');
        $coupon->begin = Carbon::createFromFormat('d/m/Y', $request->input('begin'))->startOfDay();
        $coupon->end = Carbon::createFromFormat('d/m/Y', $request->input('end'))->endOfDay();
        $coupon->save();

        return redirect()->route('coupons.index');
    }
}
