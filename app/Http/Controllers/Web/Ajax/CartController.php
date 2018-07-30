<?php

namespace App\Http\Controllers\Web\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Buy;
use App\Models\Product;
use App\Models\Stock;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|string',
            'quantity'   => 'required|numeric|between:1,10',
            'size'       => 'nullable|string',
        ]);

        $product = Product::findByHash($request->input('product_id'));

        if ($request->filled('size')) {
            $stock = Stock::findByHash($request->input('size'));

            \CartBipolar::add($request->input('quantity'), $product, $stock->id);
        } else {
            \CartBipolar::add($request->input('quantity'), $product);
        }

        \Session::flash('success_add_product', $product->name);

        return response()->json(['success' => true]);
    }

    public function destroy_buy($buyHashId)
    {
        $buy = Buy::findByHash($buyHashId);

        $this->authorize('destroy', $buy);

        $buy->load(['payments', 'details']);

        $buy->payments->each(function ($payment) {
            $payment->delete();
        });
        $buy->details->each(function ($detail) {
            $detail->delete();
        });

        $buy->delete();

        return response()->json(['success' => true]);
    }
}
