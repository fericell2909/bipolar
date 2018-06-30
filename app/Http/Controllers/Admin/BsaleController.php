<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\BSale;
use Zttp\Zttp;

class BsaleController extends Controller
{
    private $token;

    public function products()
    {
        /** @var \Zttp\ZttpResponse $response */
        $response = BSale::stocksGet();

        if (!$response->isSuccess()) {
            return response()->json(['stocks' => []]);
        }

        $content = $response->json();

        $items = collect($content['items']);

        $items = $items->map(function ($item) {
            $productName = data_get($item, "variant.product.name", "--");
            $officeName = data_get($item, "office.name", "--");
            $variant = data_get($item, "variant.description", 'Sin variante');
            $quantity = $item["quantityAvailable"];
            $variantId = data_get($item, "variant.id", "0");

            return [
                'id'           => $variantId,
                'product_name' => $productName,
                'office_name'  => $officeName,
                'quantity'     => $quantity,
                'text'         => "{$productName} x {$quantity} en {$officeName} - Variante: {$variant}",
            ];
        });

        return response()->json($items->toArray());
    }
}
