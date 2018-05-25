<?php

namespace App\Http\Controllers\Web\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
