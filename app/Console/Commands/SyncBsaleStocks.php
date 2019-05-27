<?php

namespace App\Console\Commands;

use App\Http\Services\BSale;
use App\Models\Stock;
use Illuminate\Console\Command;

class SyncBsaleStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bsale:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the bsale stock every minute';

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
        $stocks = Stock::whereNotNull('bsale_stock_ids')->get();

        if ($stocks->count() === 0) {
            return;
        }

        $response = BSale::stocksForSync();

        if (!$response->isSuccess()) {
            return;
        }

        $content = $response->json();

        $items = collect($content['items']);

        $bsaleItems = $items->filter(function ($bsaleStock) {
            return array_has($bsaleStock, ['quantityAvailable', 'variant.id']);
        })
            ->map(function ($bsaleStock) {
                // build arrays like this ["stockVariantId" => 13, "quantity" => 1]
                $stockVariantId = intval(array_get($bsaleStock, 'variant.id'));
                $quantity = intval(array_get($bsaleStock, 'quantityAvailable', 0));
                $quantity = $quantity > 0 ? $quantity : 0;
                return compact('stockVariantId', 'quantity');
            });

        $stocksWithStock = Stock::whereNotNull('bsale_stock_ids')->get();
        $newStocksWithQuantity = $stocksWithStock->map(function ($stock) use ($bsaleItems) {
            /** @var Stock $stock */
            $bsaleItemsFromThisStock = $bsaleItems->sum(function ($bsaleItem) use ($stock) {
                if (in_array($bsaleItem['stockVariantId'], $stock->bsale_stock_ids)) {
                    return $bsaleItem['quantity'];
                }
            });

            return ['bipolarStockId' => $stock->id, 'quantitySum' => $bsaleItemsFromThisStock];
        })->sortByDesc('quantitySum');

        $newStocksWithQuantity = $newStocksWithQuantity->groupBy('quantitySum');

        $newStocksWithQuantity->each(function ($bipolarStockWithQuantity, $quantityKey) {
            $stockIds = array_pluck($bipolarStockWithQuantity, "bipolarStockId");
            Stock::whereIn('id', $stockIds)->update(['quantity' => $quantityKey]);
        });
    }
}
