<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\BSale;
use App\Http\Services\BsaleCrawler;

class BsaleController extends Controller
{
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
                'label' => data_get($item, 'product.name', '--') . " - " . data_get($item, 'description', '--'),
                'value' => data_get($item, 'id', '--'),
            ];
        });

        return response()->json($items);
    }

    public function searchProductsFromCrawler()
    {
        $text = request()->input('text');
        $page = request()->input('page') ?? 1;
        $response = BsaleCrawler::search($text, $page);

        if (!$response->isSuccess()) {
            \Log::error("[Bsale Crawler Search Products] Error getting products with text: $text");

            return response()->json([
                [
                    'label' => '[Error] Falló obtener productos desde Bsale Crawler',
                    'value' => 'error',
                ],
            ]);
        }

        $contents = $response->json();

        $items = collect(data_get($contents, 'search', []));

        $items = $items->map(function ($item) {
            return [
                'label' => data_get($item, 'variante_producto.nombre_sin_sku', '--') . " (x" . data_get($item, 'variante_producto.stock_variante', '--') . ")",
                'value' => data_get($item, 'variante_producto.id_variante_producto', '--'),
            ];
        });

        return response()->json($items);
    }

    public function getVariantsFromIds()
    {
        if (!request()->filled('variants')) {
            return response()->json([]);
        }

        $variants = explode(',', request()->input('variants'));

        $variants = collect($variants)->map(function ($variantId) {
            $response = BSale::variantGet($variantId);

            if (!$response->isSuccess()) {
                return ['label' => 'Error: No se pudo obtener variante', 'value' => 'error'];
            }

            $item = $response->json();

            return [
                'label' => data_get($item, 'product.name') . ' - ' . data_get($item, 'description'),
                'value' => data_get($item, 'id'),
            ];
        });

        return response()->json($variants);
    }
}
