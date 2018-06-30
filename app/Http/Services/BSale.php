<?php

namespace App\Http\Services;

use App\Models\Buy;
use App\Models\BuyDetail;
use Zttp\Zttp;

class BSale
{
    public static function documentCreate(Buy $buy)
    {
        /** @link https://github.com/gmontero/API-Bsale/wiki/Documentos#wiki-post-un-documento */
        /** @var \Zttp\ZttpResponse $responseConsume */

        $buy->load(['details', 'details.stock.product', 'shipping_address', 'user']);

        $buyDetails = [];
        $buy->details->each(function ($detail) use (&$buyDetails) {
            /** @var BuyDetail $detail */
            return array_push($buyDetails, [
                'variantId'    => $detail->stock->bsale_stock_id,
                // todo: change USD/PEN this if we need it
                'netUnitValue' => $detail->stock->product->price_pen_discount,
                'quantity'     => $detail->quantity,
                'comment'      => "{$detail->quantity} x {$detail->stock->product->price_pen_discount}",
            ]);
        });

        $dataDocument = [
            'documentTypeId' => env('BSALE_SELL_DOCUMENT_TYPE', 23),
            'emissionDate'   => now()->timestamp,
            'expirationDate' => now()->addMonth()->timestamp,
            'declareSii'     => intval(false),
            'details'        => $buyDetails,
            'client'         => [
                'firstName'    => $buy->user->name,
                'code'         => $buy->user->id,
                'city'         => $buy->shipping_address->country_state->name,
                'municipality' => $buy->shipping_address->country_state->name,
                'address'      => $buy->shipping_address->address,
                'email'        => $buy->user->email,
            ],
        ];

        $response = Zttp::asJson()->withHeaders(['access_token' => env('BSALE_TOKEN')])
            ->post('https://api.bsale.cl/v1/documents.json', $dataDocument);

        return $response;
    }
}