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

        $this->cart->load(['details']);
    }

    /**
     * Return the last cart
     *
     * @return Cart
     */
    public function last()
    {
        return $this->cart;
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
        $this->cart = $this->cart->fresh();

        if (empty($this->cart)) {
            return;
        }

        if ($this->cart->details->count() === 0) {
            $this->cart->subtotal = 0;
            $this->cart->total = 0;
            $this->cart->total_dolar = 0;
            return $this->cart->save();
        }

        $total = $this->cart->details->sum(function ($detail) {
            return $detail->total;
        });
        $totalDolar = $this->cart->details->sum(function ($detail) {
            return $detail->total_dolar;
        });

        $this->cart->subtotal = $total;
        $this->cart->total = $total;
        $this->cart->total_dolar = $totalDolar;
        return $this->cart->save();
    }

    public function remove($productSlug)
    {
        $this->cart->details->each(function ($detail) use ($productSlug) {
            return $detail->product->slug === $productSlug ? $detail->delete() : false;
        });

        $this->recalculate();

        return true;
    }

    public function destroy()
    {
        $this->cart->details->each(function ($detail) {
            return $detail->delete();
        });

        $this->cart->delete();

        $this->recalculate();

        return true;
    }
}
