<?php

namespace App\Http\Controllers\Web\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findByHash($request->input('product_id'));

        $cart = null;
        if (\Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => \Auth::id()]);
        } else {
            $cart = Cart::firstOrCreate(['session_id' => \Session::getId()]);
        }

        $cartDetail = CartDetail::firstOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        if ($cart->wasRecentlyCreated === false) {
            $cartDetail->quantity++;
            $cartDetail->save();
        }

        return response()->json(['success' => true]);
    }
}
