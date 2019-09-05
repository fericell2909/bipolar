<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\BSale;

class BsaleController extends Controller
{
    public function products()
    {
        $response = BSale::stocksGet();

        if (!$response->isSuccess()) {
            \Log::info('Admin: Error getting stock from Bsale', $response->json());
            return response()->json([]);
        }

        $content = $response->json();

        $items = collect($content['items']);

        $items = $items->map(function ($item) {
            $productName = data_get($item, "variant.product.name", "--");
            $sku = data_get($item, "variant.code", "SIN SKU");
            $officeName = data_get($item, "office.name", "--");
            $variant = data_get($item, "variant.description", 'Sin variante');
            $quantity = intval($item["quantityAvailable"]) >= 0 ? $item["quantityAvailable"] : 0;
            $stockVariantId = data_get($item, "variant.id", "0");

            return [
                'id'           => $stockVariantId,
                'product_name' => $productName,
                'office_name'  => $officeName,
                'sku'          => $sku,
                'quantity'     => $quantity,
                'text'         => "{$productName} x {$quantity} en {$officeName} - Variante: {$variant} - SKU: {$sku}",
            ];
        })->sortByDesc('quantity')->values();

        return response()->json($items->toArray());
    }
}
