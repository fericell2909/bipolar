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

    public function searchProducts()
    {
        $text = request()->input('text');
        $response = BSale::searchProductForSelect($text);

        if (!$response->isSuccess()) {
            \Log::error("[Bsale Search Products] Error getting products with text: $text");

            return response()->json([['label' => '[Error] Falló obtener productos desde Bsale', 'value' => 'error']]);
        }

        $contents = $response->json();

        $items = collect($contents['items']);

        $items = $items->map(function ($item) {
            return [
                'label' => data_get($item, 'name', '--'),
                'value' => data_get($item, 'id', '--'),
            ];
        });

        return response()->json($items);
    }

    public function getVariantsByProductId(int $productId)
    {
        $response = BSale::getVariantsByProduct($productId);

        if (!$response->isSuccess()) {
            \Log::error("[Bsale Search Products] Error getting variants for product: {$productId}");

            return response()->json([
                [
                    'label' => "[Error] Falló obtener variantes para producto {$productId} desde Bsale",
                    'value' => 'error',
                ],
            ]);
        }

        $contents = $response->json();

        $items = collect($contents['items']);

        $items = $items->map(function ($item) {
            return [
                'label' => data_get($item, 'description', '--'),
                'value' => data_get($item, 'id', '--'),
            ];
        });

        return response()->json($items);
    }
}
