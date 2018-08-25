<?php

namespace App\Listeners;

use App\Events\SaleSuccessful;
use App\Http\Services\BSale;
use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Stock;

class BsaleDocumentCreation
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
     * @param  SaleSuccessful $event
     * @return void
     */
    public function handle(SaleSuccessful $event)
    {
        $buy = $event->buy;
        $response = BSale::documentCreate($buy);
        if ($response->isSuccess()) {
            $content = $response->json();
            $buy->bsale_document_url = array_get($content, 'urlPdf');
            $buy->save();
        } else {
            \Log::warning($response->body());
        }
    }

    private function deleteProductWithoutStock(Buy $buy)
    {
        $buy->loadMissing(['details.product.stock']);
        $buy->details
            ->reject(function ($detail) {
                /** @var BuyDetail $detail */
                return blank($detail->stock_id);
            })
            ->each($this->compareProductsStocksWithEmptyStock());
    }

    private function compareProductsStocksWithEmptyStock()
    {
        return function ($detail) {
            /** @var BuyDetail $detail */
            if (blank($detail->product)) {
                return false;
            }

            $stocksPerProduct = $detail->product->stocks->count();
            $emptyStocksPerProduct = $detail->product->stocks->filter(function ($stock) {
                /** @var Stock $stock */
                return $stock->quantity = 0;
            })->count();

            if ($stocksPerProduct === $emptyStocksPerProduct) {
                $detail->product->delete();
            }

            return true;
        };
    }
}
