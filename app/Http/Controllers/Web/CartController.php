<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CartDetail;

class CartController extends Controller
{
    public function cart()
    {
        return view('web.shop.cart');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required|array',
        ]);

        foreach ($request->input('quantity') as $detailHashId => $quantity) {
            $cartDetail = CartDetail::findByHash($detailHashId);
            $pricePEN = $cartDetail->product->discount ? $cartDetail->product->price_discount : $cartDetail->product->price;
            $priceUSD = $cartDetail->product->discount ? $cartDetail->product->price_dolar_discount : $cartDetail->product->price_dolar;
            $cartDetail->quantity = $quantity;
            $cartDetail->total = $quantity * $pricePEN;
            $cartDetail->total_dolar = $quantity * $priceUSD;
            $cartDetail->save();
        }

        \CartBipolar::recalculate();

        return redirect()->back();
    }

    public function remove($productSlug)
    {
        \CartBipolar::remove($productSlug);

        return redirect()->back();
    }
}
