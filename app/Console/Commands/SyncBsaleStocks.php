<?php

namespace App\Console\Commands;

use App\Http\Services\BSale;
use App\Models\Stock;
use Illuminate\Console\Command;
use Zttp\Zttp;

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
        $stocks = Stock::whereNotNull('bsale_stock_id')->get();

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
                // build arrays like this ["variantId" => 13, "quantity" => 0]
                $variantId = intval(array_get($bsaleStock, 'variant.id'));
                $quantity = intval(array_get($bsaleStock, 'quantityAvailable', 0));
                $quantity = $quantity > 0 ? $quantity : 0;
                return compact('variantId', 'quantity');
            });


        $bsaleItems = $bsaleItems->groupBy('quantity');

        $bsaleItems->each(function ($bsaleItemsByQuantity, $quantityKey) {
            $variantIds = array_pluck($bsaleItemsByQuantity, "variantId");
            Stock::whereIn('bsale_stock_id', $variantIds)->update(['quantity' => $quantityKey]);
        });
    }
}
