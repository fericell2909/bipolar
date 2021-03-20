<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CouponNewRequest;
use App\Http\Requests\Admin\CouponUpdateRequest;
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

        return view('admin.coupons.new', compact('types'));
    }

    public function store(CouponNewRequest $request)
    {
        $coupon = new Coupon;
        $coupon->code = $request->input('code');
        $coupon->type_id = $request->input('coupon_type');
        $coupon->amount_pen = $request->input('amount_pen');
        $coupon->amount_usd = $request->input('amount_usd');
        $coupon->frequency = $request->input('limit');
        $coupon->minimum_pen = $request->input('minimum_pen');
        $coupon->minimum_usd = $request->input('minimum_usd');
        $coupon->discounted_products = boolval($request->input('discount_products'));
        $coupon->begin = Carbon::createFromFormat('d/m/Y', $request->input('begin'))->startOfDay();
        $coupon->end = Carbon::createFromFormat('d/m/Y', $request->input('end'))->endOfDay();
        $coupon->vcupon = 1;
        if((boolean)$request->input('isunique') === true){
            $coupon->isunique = 1;
        } else {
            $coupon->isunique = 0;
        }
        $coupon->quantityproducts = $request->input('quantityproducts');

        $coupon->save();

        flash()->success('Cupón creado con éxito');

        return redirect()->route('coupons.associate', $coupon->id);
    }

    public function associate($coupondId)
    {
        $coupon = Coupon::findOrFail($coupondId);

        return view('admin.coupons.relations', compact('coupon'));
    }

    public function edit($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        $types = CouponType::all()->pluck('name', 'id')->toArray();

        return view('admin.coupons.edit', compact('coupon', 'types'));
    }

    public function update(CouponUpdateRequest $request, $couponId)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::findOrFail($couponId);
        $coupon->code = $request->input('code');
        $coupon->type_id = $request->input('coupon_type');
        $coupon->amount_pen = $request->input('amount_pen');
        $coupon->amount_usd = $request->input('amount_usd');
        $coupon->frequency = $request->input('limit');
        $coupon->minimum_pen = $request->input('minimum_pen');
        $coupon->minimum_usd = $request->input('minimum_usd');
        $coupon->discounted_products = boolval($request->input('discount_products'));
        $coupon->begin = Carbon::createFromFormat('d/m/Y', $request->input('begin'))->startOfDay();
        $coupon->end = Carbon::createFromFormat('d/m/Y', $request->input('end'))->endOfDay();

        if($coupon->vcupon > 0){
            $coupon->vcupon = 1;
        }
        
        if((boolean)$request->input('isunique') === true){
            $coupon->isunique = 1;
        } else {
            $coupon->isunique = 0;
        }
        $coupon->quantityproducts = $request->input('quantityproducts');

        $coupon->save();

        flash()->success('Cupón actualizado con éxito');

        return redirect()->route('coupons.index');
    }
}
