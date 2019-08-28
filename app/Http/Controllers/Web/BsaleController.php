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
        if ($request->input('topic') === 'stock' && $request->filled('resourceId')) {
            $this->updateFromStockResource($request->input('resourceId'));
        } elseif ($request->input('topic') === 'document' && $request->filled('resourceId')) {
            $this->updateFromDocumentResource($request->input('resourceId'));
        } else {
            return \Log::info('BSALE: Unknow event', $request->all());
        }

        return response()->json(['message' => 'Bsale: Stock updated']);
    }

    private function updateFromDocumentResource($documentId)
    {
        $response = BSale::documentGet(intval($documentId));

        if (!$response->isOk()) {
            return \Log::info('BSALE: Update from document failed');
        }

        $document = $response->json();
        $variantIds = data_get($document, 'details.items.*.variant.id');

        if (count($variantIds) === 0) {
            return \Log::info('BSALE: No variant Ids detected');
        }

        foreach ($variantIds as $variantId) {
            $this->updateFromStockResource($variantId);
        }
    }

    private function updateFromStockResource($bsaleVariantId)
    {
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

        if ($newQuantity < 0) {
            $newQuantity = 0;
        }

        $stock->quantity = $newQuantity;
        $stock->save();

        // TODO: Move this log to only single channel (not slack) in 6 months. Like January 2020
        \Log::info('BSALE: Stock updated', ['Stock #' => $stock->id, 'Old qty' => $oldQuantity, 'New qty' => $newQuantity]);
    }
}