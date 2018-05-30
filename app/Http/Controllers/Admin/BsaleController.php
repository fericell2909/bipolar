<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Zttp\Zttp;

class BsaleController extends Controller
{
    private $token;

    public function __construct()
    {
        $this->token = env('BSALE_TOKEN');
    }

    public function products()
    {
        /** @var \Zttp\ZttpResponse $response */
        $response = Zttp::withHeaders(['access_token' => $this->token])
            ->get('https://api.bsale.cl/v1/stocks.json', [
                'expand' => 'office,variant.product',
                'limit' => 100000000,
            ]);

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
            $stockId = $item["id"];

            return [
                'id'           => $stockId,
                'product_name' => $productName,
                'office_name'  => $officeName,
                'quantity'     => $quantity,
                'text'         => "{$productName} x {$quantity} en {$officeName} - Variante: {$variant}",
            ];
        });

        debug($items);

        return response()->json($items->toArray());
    }
}
