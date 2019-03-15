<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class CheckProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check_stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check stock once per day';

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
        $products = Product::has('stocks')->with('stocks')->where('state_id', config('constants.STATE_ACTIVE_ID'))->get();

        $productsWithEmptyStock = $products->filter(function ($product) {
            /** @var Product $product */
            $totalStocks = $product->stocks->count();
            $emptyStocks = $product->stocks->filter(function ($stock) {
                /** @var \App\Models\Stock $stock */
                return (int)$stock->quantity === 0;
            })->count();

            return $emptyStocks === $totalStocks;
        });

        if ($productsWithEmptyStock->isNotEmpty()) {
            \Log::info("Se encontraron productos sin stock: ", ['products_without_stock' => $productsWithEmptyStock->count()]);
        }

        Product::whereIn('id', $productsWithEmptyStock->pluck('id')->toArray())->update(['state_id' => config('constants.STATE_REVIEW_ID')]);
    }
}
