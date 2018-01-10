<?php

namespace App\Http\Controllers\Web\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\Stock;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|string',
            'quantity'   => 'required|numeric',
            'size'       => 'nullable|string',
        ]);

        $product = Product::findByHash($request->input('product_id'));

        $cart = null;
        if (\Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => \Auth::id()]);
        } else {
            $cart = Cart::firstOrCreate(['session_id' => \Session::getId()]);
        }

        if ($request->filled('size')) {
            $stock = Stock::findByHash($request->input('size'));

            $cartDetail = CartDetail::firstOrCreate([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'stock_id'   => $stock->id,
            ]);
        } else {
            $cartDetail = CartDetail::firstOrCreate([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
            ]);
        }

        $cartDetail->quantity = $cartDetail->quantity + $request->input('quantity');
        $cartDetail->save();

        $cart = $this->calculateTotal($cart);

        return response()->json(['success' => true]);
    }

    private function calculateTotal(Cart $cart)
    {
        $total = $cart->details->sum(function ($detail) {
            return $detail->total;
        });

        $cart->subtotal = $total;
        $cart->total = $total;
        $cart->save();

        return $cart;
    }
}
