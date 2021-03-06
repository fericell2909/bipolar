<?php

namespace App\Listeners;

use App\Events\ProductSold;
use App\Events\SaleSuccessful;
use App\Http\Services\BSale;
use App\Models\Buy;
use App\Models\BuyDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;

class BsaleDocumentCreation implements ShouldQueue
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
            $buy->bsale_document_url = Arr::get($content, 'urlPdf');
            $buy->save();
            // Check product detail stocks and delete if is 0
            $this->removeBsaleStockIdEmpty($buy);
            event(new ProductSold($buy));
        } else {
            \Log::warning($response->body());
        }
    }

    public function failed(SaleSuccessful $event)
    {
        \Log::error("Event for {$event->buy->id} failed");
    }

    private function removeBsaleStockIdEmpty(Buy $buy)
    {
        $buy->loadMissing(['details.product.stocks']);
        $buy->details
            ->reject(function ($detail) {
                /** @var BuyDetail $detail */
                return blank($detail->stock_id);
            })
            ->reject(function ($detail) {
                /** @var BuyDetail $detail */
                return blank($detail->stock->bsale_stock_ids);
            })
            ->each($this->checkStock());
    }

    private function checkStock()
    {
        return function ($detail) {
            /** @var BuyDetail $detail */
            $stock = $detail->stock;
            $totalQuantity = 0;
            $bsaleStockIds = collect($stock->bsale_stock_ids);

            $checkedBsaleStocks = $bsaleStockIds->filter(function ($bsaleStockId) use (&$totalQuantity) {
                $response = BSale::stocksGet($bsaleStockId);
                $stockAPIResult = $response->json();
                $quantity = data_get($stockAPIResult, 'items.0.quantity');
                $totalQuantity += $quantity;

                return intval($quantity) > 0;
            })->values()->toArray();

            $stock->bsale_stock_ids = $checkedBsaleStocks;
            $stock->quantity = $totalQuantity;
            $stock->save();
        };
    }
}
