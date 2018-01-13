<?php

namespace App\Instances;

use App\Models\Cart;

class CartBipolar
{
    private $cart;

    public function __construct()
    {
        if (\Auth::check()) {
            $this->cart = Cart::firstOrCreate(['user_id' => \Auth::id()]);
        } else {
            $this->cart = Cart::firstOrCreate(['session_id' => \Session::getId()]);
        }
    }

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
        if (is_null($this->cart)) {
            return 0;
        }

        return $this->cart->details->count();
    }

    public function content()
    {
        if ($this->count() === 0) {
            return [];
        }

        return $this->cart->details;
    }

    public function totalCurrency()
    {
        return $this->cart->total_currency;
    }

    public function recalculate()
    {
        $total = $this->cart->details->sum(function ($detail) {
            return $detail->total;
        });
        $totalDolar = $this->cart->details->sum(function ($detail) {
            return $detail->total_dolar;
        });

        $cart = $this->cart;

        $cart->subtotal = $total;
        $cart->total = $total;
        $cart->total_dolar = $totalDolar;
        $cart->save();

        $this->cart = $cart;
    }
}
