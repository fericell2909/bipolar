<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\DiscountTask;
use App\Models\Type;
use App\Models\Subtype;
use Carbon\Carbon;
use App\Http\Resources\DiscountTaskResource;

class DiscountController extends Controller
{
    public function edit($hashId)
    {
        $discount = DiscountTask::findByHash($hashId);

        return new DiscountTaskResource($discount);
    }

    public function update(Request $request, $hashId)
    {
        /** @var DiscountTask $discountTask */
        $discountTask = DiscountTask::findByHash($hashId);

        $products = collect([]);
        $types = collect([]);
        $subtypes = collect([]);
        if ($request->filled('products')) {
            $products = Product::find(array_map(function ($element) {
                return $element["value"];
            }, $request->input('products')));
        }
        if ($request->filled('types')) {
            $types = Type::find(array_map(function ($element) {
                return $element["value"];
            }, $request->input('types')));
        }
        if ($request->filled('subtypes')) {
            $subtypes = Subtype::find(array_map(function ($element) {
                return $element["value"];
            }, $request->input('subtypes')));
        }

        if ($request->filled('available')) {
            $discountTask->available = $request->input('available');
        } else {
            $discountPEN = $request->input('discountPEN');
            $discountUSD = $request->input('discountUSD');
            $beginDiscount = Carbon::createFromFormat('d/m/Y', $request->input('beginDiscount'))->startOfDay();
            $endDiscount = Carbon::createFromFormat('d/m/Y', $request->input('endDiscount'))->endOfDay();

            $typesArray = $types->pluck('id')->toArray();
            $subtypesArray = $subtypes->pluck('id')->toArray();
            $productsArray = $products->pluck('id')->toArray();

            $discountTask->name = $request->input('name');
            $discountTask->begin = $beginDiscount;
            $discountTask->end = $endDiscount;
            $discountTask->discount_pen = $discountPEN;
            $discountTask->discount_usd = $discountUSD;
            $discountTask->products = count($productsArray) === 0 ? null : $productsArray;
            $discountTask->product_types = count($typesArray) === 0 ? null : $typesArray;
            $discountTask->product_subtypes = count($subtypesArray) === 0 ? null : $subtypesArray;
        }

        $discountTask->save();

        return new DiscountTaskResource($discountTask);
    }

    public function execute($hashId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findByHash($hashId);

        \Artisan::call('tasks:execute', ['--discount' => $discount->id]);

        return response()->json(['success' => true]);
    }

    public function revert($hashId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findByHash($hashId);

        \Artisan::call('tasks:revert', ['--discount' => $discount->id]);

        return response()->json(['success' => true]);
    }

    public function destroy($hashId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findByHash($hashId);

        $discount->delete();

        return response()->json(['success' => true]);
    }
}
