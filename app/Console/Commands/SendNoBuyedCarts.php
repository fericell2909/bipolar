<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Mail\CartsUnbuyed;

class SendNoBuyedCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:unbought_carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email to carts without a buy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $carts = Cart::whereHas('user', function ($whereUser) {
            return $whereUser->whereNotNull('language');
        })
            ->has('details')
            ->has('details.product')
            ->with(['details.product.photos', 'details.stock', 'details.stock.size', 'details.product', 'user'])
            ->whereNotNull('user_id')
            ->get();

        $carts = $carts
            ->filter($this->modifiedYesterday())
            ->reject($this->removeCartWithoutDetailsAndStock());

        foreach ($carts as $cart) {
            try { 
                \Mail::to($cart->user->email)->send(new CartsUnbuyed($cart));
                \Log::info("Mail enviado Carrito ", $cart);
            } catch (\Exception $e) { 
                
                \Log::error("Error al enviar carrito de compra", $cart);
            }
            
        }
    }

    /**
     * Only carts updated from 24 hours ago
     *
     */
    private function modifiedYesterday()
    {
        return function ($cart) {
            /** @var \App\Models\Cart $cart */
            return $cart->updated_at->isYesterday() && $cart->updated_at->hour === now()->hour;
        };
    }

    private function removeCartWithoutDetailsAndStock()
    {
        return function ($cart) {
            /** @var \App\Models\Cart $cart */
            $details = $cart->details->reject($this->removeDetailWithTrashedProducts());
            $details = $details->reject($this->removeDetailsWithoutStock());

            if ($details->count() === 0) {
                \DB::table('cart_details')->where('cart_id', $cart->id)->delete();
                $cart->delete();

                return true;
            }

            return false;
        };
    }

    private function removeDetailWithTrashedProducts()
    {
        return function ($detail) {
            /** @var \App\Models\CartDetail $detail */
            if ($detail->product->trashed()) {
                $detail->delete();

                return true;
            }

            return false;
        };
    }

    private function removeDetailsWithoutStock()
    {
        return function ($detail) {
            /** @var \App\Models\CartDetail $detail */
            if (is_null($detail->stock)) {
                return false;
            }

            return $detail->stock->quantity === 0;
        };
    }
}
