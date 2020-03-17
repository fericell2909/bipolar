<?php

namespace App\Listeners;

use App\Events\ProductSold;
use App\Models\BuyDetail;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class ProductCheckIfSoldOut implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ProductSold $event
     * @return void
     */
    public function handle(ProductSold $event)
    {
        $buy = $event->buy->fresh(['details']);

        $productIds = $buy->details->map(function ($detail) {
            /** @var BuyDetail $detail */
            return $detail->product_id;
        })->toArray();

        /** @var Collection $products */
        $products = Product::whereIn('id', $productIds)->with('stocks')->get();

        $emptyProducts = $products->filter(function ($product) {
            /** @var Product $product */
            $totalStocks = $product->stocks->count();
            $totalEmptyStocks = $product->stocks->filter(function ($stock) {
                /** @var Stock $stock */
                return $stock->quantity === 0;
            })->count();

            return $totalStocks === $totalEmptyStocks;
        });

        if ($emptyProducts->isEmpty()) {
            return;
        }

        $emptyProductsIds = $emptyProducts->map(function ($product) {
            /** @var Product $product */
            return $product->id;
        })->values()->toArray();

        CartDetail::whereIn('product_id', $emptyProductsIds)->delete();

        Product::whereIn('id', $emptyProductsIds)->update(['is_soldout' => true]);

        return;
    }

    /**
     * Handle the event.
     *
     * @param ProductSold $event
     * @return void
     */
    public function failed(ProductSold $event)
    {
        \Log::error("Failed to check if products for buy {$event->buy->id} were sold");
    }
}
