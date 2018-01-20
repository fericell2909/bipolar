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
            $cartDetail->quantity = $quantity;
            $cartDetail->total = $quantity * $cartDetail->product->price;
            $cartDetail->total_dolar = $quantity * $cartDetail->product->price_dolar;
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
