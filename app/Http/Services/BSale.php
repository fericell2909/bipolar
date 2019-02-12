<?php

namespace App\Http\Services;

use App\Models\Buy;
use App\Models\BuyDetail;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class BSale
{
    /**
     * @return ZttpResponse
     */
    public static function stocksGet(): ZttpResponse
    {
        $response = Zttp::withHeaders(['access_token' => env('BSALE_TOKEN')])
            ->get('https://api.bsale.cl/v1/stocks.json', [
                'expand'   => 'office,variant.product',
                'limit'    => 100000000,
                'officeid' => env('BSALE_MAIN_OFFICE', 1),
            ]);

        return $response;
    }

    /**
     * @return ZttpResponse
     */
    public static function stocksForSync(): ZttpResponse
    {
        $response = Zttp::withHeaders(['access_token' => env('BSALE_TOKEN')])
            ->get('https://api.bsale.cl/v1/stocks.json', [
                'limit'    => 100000000,
                'officeid' => env('BSALE_MAIN_OFFICE', 1),
            ]);

        return $response;
    }

    /**
     * @param Buy $buy
     * @return ZttpResponse
     */
    public static function documentCreate(Buy $buy): ZttpResponse
    {
        /** @link https://github.com/gmontero/API-Bsale/wiki/Documentos#wiki-post-un-documento */

        $buy->load(['details', 'details.stock.product', 'shipping_address', 'user']);

        $onlyDetailsWithBsaleStock = $buy->details->filter(function ($detail) {
            /** @var BuyDetail $detail */
            if (is_null($detail->stock_id)) {
                return false;
            }

            if (is_null($detail->stock->bsale_stock_id)) {
                return false;
            }

            return $detail->stock->bsale_stock_id;
        });

        $buyDetails = $onlyDetailsWithBsaleStock->map(function ($detail) {
            /** @var BuyDetail $detail */
            return [
                'variantId' => $detail->stock->bsale_stock_id,
                'quantity'  => $detail->quantity,
                'comment'   => "{$detail->quantity} x {$detail->stock->product->price_pen_discount}",
            ];
        })->toArray();

        $dataDocument = [
            'documentTypeId' => strval(env('BSALE_SELL_DOCUMENT_TYPE', 23)),
            'priceListId'    => $buy->currency === 'USD' ? strval(env('BSALE_PRICE_LIST_USD')) : strval(env('BSALE_PRICE_LIST_PEN')),
            'emissionDate'   => now()->timestamp,
            'expirationDate' => now()->addMonth()->timestamp,
            'declareSii'     => intval(false),
            'details'        => $buyDetails,
            'client'         => [
                'firstName'    => $buy->user->name,
                'city'         => $buy->shipping_address->country_state->name,
                'municipality' => $buy->shipping_address->country_state->name,
                'address'      => $buy->shipping_address->address,
                'email'        => $buy->user->email,
            ],
        ];

        \Log::info("Documento creado", $dataDocument);

        $response = Zttp::asJson()->withHeaders(['access_token' => env('BSALE_TOKEN')])
            ->post('https://api.bsale.cl/v1/documents.json', $dataDocument);

        return $response;
    }
}
