<?php

namespace App\Instances;

use App\Models\Cart;

class CartBipolar
{
    /**
     * Return the last cart
     *
     * @return Cart|null
     */
    public function last()
    {
        $cart = null;
        if (\Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => \Auth::id()]);
        } else {
            $cart = Cart::firstOrCreate(['session_id' => \Session::getId()]);
        }

        return $cart;
    }

    public function count()
    {
        $cart = $this->last();

        if (is_null($cart)) {
            return 0;
        }

        return $cart->details->count();
    }

    public function content()
    {
        if ($this->count() === 0) {
            return [];
        }

        return $this->last()->details;
    }

    public function totalCurrency()
    {
        return $this->last()->total_currency;
    }

    public function recalculate()
    {
        $cart = $this->last();

        $total = $cart->details->sum(function ($detail) {
            return $detail->total;
        });
        $totalDolar = $cart->details->sum(function ($detail) {
            return $detail->total_dolar;
        });

        $cart->subtotal = $total;
        $cart->total = $total;
        $cart->total_dolar = $totalDolar;
        $cart->save();
    }
}
