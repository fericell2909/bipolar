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
        $discountTasks = DiscountTask::orderByDesc('id')->get();

        $productsIds = $discountTasks->pluck('products')->flatten()->toArray();
        $typesIds = $discountTasks->pluck('product_types')->flatten()->toArray();
        $subtypesIds = $discountTasks->pluck('product_subtypes')->flatten()->toArray();
        
        $products = Product::whereIn('id', $productsIds)->with(['stocks.size', 'colors'])->get();
        $types = Type::find($typesIds);
        $subtypes = Subtype::find($subtypesIds);

        $discountTasks = $discountTasks->map(function ($discountTask) use ($products, $types, $subtypes) {
            $discountTask->products_model = $products->whereIn('id', $discountTask->products);
            $discountTask->types_model = $types->whereIn('id', $discountTask->product_types);
            $discountTask->subtypes_model = $subtypes->whereIn('id', $discountTask->product_subtypes);
            return $discountTask;
        });

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

    public function edit($discountTaskId)
    {
        $discount = DiscountTask::find($discountTaskId);

        return new DiscountTaskResource($discount);
    }

    public function update(Request $request, $discountTaskId)
    {
        /** @var DiscountTask $discountTask */
        $discountTask = DiscountTask::findOrFail($discountTaskId);

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

    public function execute($discountTaskId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findOrFail($discountTaskId);

        \Artisan::call('tasks:execute', ['--discount' => $discount->id]);

        return response()->json(['success' => true]);
    }

    public function revert($discountTaskId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findOrFail($discountTaskId);

        \Artisan::call('tasks:revert', ['--discount' => $discount->id]);

        return response()->json(['success' => true]);
    }

    public function destroy($discountTaskId)
    {
        /** @var DiscountTask $discount */
        $discount = DiscountTask::findOrFail($discountTaskId);

        $discount->delete();

        return response()->json(['success' => true]);
    }
}
