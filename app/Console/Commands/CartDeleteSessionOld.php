<?php

namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;

class CartDeleteSessionOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:cart_delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove session carts';

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
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('cart_details')->truncate();
        \DB::table('carts')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
