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
    protected $signature = 'carts:unbuyed';

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
        $carts = Cart::has('details')->whereNotNull('user_id')->get();

        foreach ($carts as $cart) {
            \Mail::to($cart->user->email)->send(new CartsUnbuyed($cart));
        }

        $this->info("Se enviaron correos a {$carts->count()} personas");
    }
}
