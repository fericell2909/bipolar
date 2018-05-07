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
    public function index()
    {
        $discountTasks = DiscountTask::all();

        return DiscountTaskResource::collection($discountTasks);
    }

    public function store(Request $request)
    {
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
        $discountPEN = $request->input('discountPEN');
        $discountUSD = $request->input('discountUSD');
        $beginDiscount = Carbon::createFromFormat('d/m/Y', $request->input('beginDiscount'))->startOfDay();
        $endDiscount = Carbon::createFromFormat('d/m/Y', $request->input('endDiscount'))->endOfDay();
        $convertToNull = false;

        if (intval($discountPEN) === 0 && intval($discountUSD) === 0) {
            $convertToNull = true;
        }

        $typesArray = $types->pluck('id')->toArray();
        $subtypesArray = $subtypes->pluck('id')->toArray();
        $productsArray = $products->pluck('id')->toArray();

        $discountTask = new DiscountTask;
        $discountTask->name = $request->input('name');
        $discountTask->begin = $beginDiscount;
        $discountTask->end = $endDiscount;
        $discountTask->discount_pen = $discountPEN;
        $discountTask->discount_usd = $discountUSD;
        $discountTask->products = count($productsArray) === 0 ? null : $productsArray;
        $discountTask->product_types = count($typesArray) === 0 ? null : $typesArray;
        $discountTask->product_subtypes = count($subtypesArray) === 0 ? null : $subtypesArray;
        $discountTask->save();
        
        return response()->json(['message' => 'Creado']);
    }

    public function update(Request $request, $discountTaskId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findOrFail($discountTaskId);

        if ($request->filled('available')) {
            $discount->available = $request->input('available');
        }

        $discount->save();

        return new DiscountTaskResource($discount);
    }

    public function execute($discountTaskId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findOrFail($discountTaskId);

        $mainParams = [
            'discount_pen'   => $discount->discount_pen,
            'discount_usd'   => $discount->discount_usd,
            'begin_discount' => $discount->begin,
            'end_discount'   => $discount->end,
        ];

        if (count($discount->product_types)) {
            $types = Type::find($discount->product_types);
            foreach ($types as $type) {
                foreach ($type->subtypes as $subtype) {
                    $subtype->products->each($this->assignMassiveDiscount($discount->discount_pen, $discount->discount_usd, $mainParams, false));
                }
            }
        }

        if (count($discount->product_subtypes)) {
            $subtypes = Subtype::find($discount->product_subtypes);
            foreach ($subtypes as $subtype) {
                $subtype->products->each($this->assignMassiveDiscount($discount->discount_pen, $discount->discount_usd, $mainParams, false));
            }
        }

        if (count($discount->products) > 0) {
            $products = Product::find($discount->products);
            $products->each($this->assignMassiveDiscount($discount->discount_pen, $discount->discount_usd, $mainParams, false));
        }

        $discount->executed = true;
        $discount->save();

        return response()->json(['success' => true]);
    }

    public function revert($discountTaskId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findOrFail($discountTaskId);

        $mainParams = [
            'discount_pen'   => null,
            'discount_usd'   => null,
            'begin_discount' => null,
            'end_discount'   => null,
        ];

        if (count($discount->product_types)) {
            $types = Type::find($discount->product_types);
            foreach ($types as $type) {
                foreach ($type->subtypes as $subtype) {
                    $subtype->products->each($this->assignMassiveDiscount(0, 0, $mainParams, true));
                }
            }
        }

        if (count($discount->product_subtypes)) {
            $subtypes = Subtype::find($discount->product_subtypes);
            foreach ($subtypes as $subtype) {
                $subtype->products->each($this->assignMassiveDiscount(0, 0, $mainParams, true));
            }
        }

        if (count($discount->products) > 0) {
            $products = Product::find($discount->products);
            $products->each($this->assignMassiveDiscount(0, 0, $mainParams, true));
        }

        $discount->executed = false;
        $discount->save();

        return response()->json(['success' => true]);
    }

    private function assignMassiveDiscount($discountPEN, $discountUSD, $mainParams, $convertToNull)
    {
        return function ($product) use ($discountPEN, $discountUSD, $mainParams, $convertToNull) {
            /** @var Product $product */
            $specificParams = [
                'price_pen_discount' => $convertToNull ? null : $product->price - calculate_percentage($product->price, $discountPEN),
                'price_usd_discount' => $convertToNull ? null : $product->price_dolar - calculate_percentage($product->price_dolar, $discountUSD),
            ];

            $updateParams = array_merge($mainParams, $specificParams);

            $product->update($updateParams);
        };
    }
}
