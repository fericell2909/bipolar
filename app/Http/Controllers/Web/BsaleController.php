<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\BSale;
use App\Models\Stock;
use Illuminate\Http\Request;

class BsaleController extends Controller
{
    public function sync(Request $request)
    {

        if ($request->input('topic') !== 'stock' || !$request->filled('resourceId')) {
            \Log::info('BSALE: Event logged', $request->all());
            // We don't need another info
            return;
        }

        $bsaleVariantId = $request->input('resourceId');

        /** @var Stock $stock */
        $stock = Stock::where('bsale_stock_ids', 'LIKE', "%{$bsaleVariantId}%")->first();

        if (!$stock) {
            return;
        }

        $oldQuantity = $stock->quantity;
        $newQuantity = 0;

        foreach ($stock->bsale_stock_ids as $bsaleStockId) {
            $bsaleVariantResponse = BSale::stocksGet($bsaleStockId);
            $response = $bsaleVariantResponse->json();
            $quantity = data_get($response, 'items.0.quantityAvailable');
            $newQuantity += $quantity;
        }

        $stock->quantity = $newQuantity;
        $stock->save();

        // TODO: Move this log to only single channel (not slack) in 6 months. Like January 2020
        \Log::info('BSALE: Stock updated', ['Stock #' => $stock->id, 'Old qty' => $oldQuantity, 'New qty' => $newQuantity]);

        return response()->json(['message' => 'Bsale: Stock updated']);
    }
}