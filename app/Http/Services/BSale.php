<?php

namespace App\Http\Services;

use App\Models\Buy;
use App\Models\BuyDetail;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class BSale
{
    /**
     * @param null $variantId
     * @return ZttpResponse
     */
    public static function stocksGet($variantId = null): ZttpResponse
    {
        $params = [
            'expand'   => 'office,variant.product',
            'limit'    => 100000000,
            'officeid' => env('BSALE_MAIN_OFFICE', 1),
        ];

        if (filled($variantId)) {
            $params = [
                'limit'     => 1,
                'officeid'  => env('BSALE_MAIN_OFFICE', 1),
                'variantid' => $variantId,
            ];
        }

        $response = Zttp::withHeaders(['access_token' => env('BSALE_TOKEN')])
            ->get('https://api.bsale.cl/v1/stocks.json', $params);

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

            if (is_null($detail->stock->bsale_stock_ids)) {
                return false;
            }

            return $detail->stock->bsale_stock_ids;
        });

        $bsaleDetails = [];
        $onlyDetailsWithBsaleStock->each(function ($detail) use (&$bsaleDetails) {
            /** @var BuyDetail $detail */
            $quantityToSubstract = $detail->quantity;

            collect($detail->stock->bsale_stock_ids)->map(function ($bsaleStockVariantId) {
                try {
                    $bsaleVariantResponse = self::stocksGet($bsaleStockVariantId);

                    $response = $bsaleVariantResponse->json();

                    $variantId = data_get($response, 'items.0.variant.id');
                    $quantity = data_get($response, 'items.0.quantityAvailable');

                    return compact('variantId', 'quantity');
                } catch (\Throwable $th) {
                    \Log::warning("No se puede obtener stock {$bsaleStockVariantId} para reducirlo");
                }
            })
                ->sortBy('quantity')
                ->each(function ($variantIdAndQuantityObject) use (&$bsaleDetails, &$quantityToSubstract, $detail) {
                    // Current format ['variantId' => XXXX, 'quantity' => XX]
                    if ($quantityToSubstract >= $variantIdAndQuantityObject['quantity']) {
                        $quantityToSubstract = $quantityToSubstract - $variantIdAndQuantityObject['quantity'];

                        return array_push($bsaleDetails, [
                            'variantId' => $variantIdAndQuantityObject['variantId'],
                            'quantity'  => $variantIdAndQuantityObject['quantity'],
                            'comment'   => "{$variantIdAndQuantityObject['quantity']} x {$detail->total_currency}",
                        ]);
                    } else {
                        array_push($bsaleDetails, [
                            'variantId' => $variantIdAndQuantityObject['variantId'],
                            'quantity'  => $quantityToSubstract,
                            'comment'   => "{$quantityToSubstract} x {$detail->total_currency}",
                        ]);

                        return $quantityToSubstract = 0;
                    }
                });
        });

        $dataDocument = [
            'documentTypeId' => strval(env('BSALE_SELL_DOCUMENT_TYPE', 23)),
            'priceListId'    => $buy->currency === 'USD' ? strval(env('BSALE_PRICE_LIST_USD')) : strval(env('BSALE_PRICE_LIST_PEN')),
            'emissionDate'   => now()->timestamp,
            'expirationDate' => now()->addMonth()->timestamp,
            'declareSii'     => intval(false),
            'details'        => $bsaleDetails,
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
