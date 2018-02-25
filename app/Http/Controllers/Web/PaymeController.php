<?php

namespace App\Http\Controllers\Web;

use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\Shipping;
use App\Models\ShippingInclude;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymeController extends Controller
{
    public function pagoPayme(Request $request, $buyId)
    {
        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);

        $this->calculateShippingFee($buy);

        $this->authorize('view', $buy);

        $buy->buy_number = $this->getCurrentBuyNumber();
        $buy->save();

        $tokenUsuario = $this->getOrRegisterInWallet($request);

        $acquirerId = env('PAYME_ACQUIRER_ID');
        $idCommerce = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? env('PAYME_COMMERCE_ID') : env('PAYME_COMMERCE_ID_ENGLISH');
        $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
        $purchaseAmount = intval($buy->total_session * 100);
        $purchaseCurrencyCode = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? '840' : '604';
        $claveVPOS = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? env('PAYME_VPOS_COMMERCE_SECRET') : env('PAYME_VPOS_COMMERCE_SECRET_ENGLISH');

        $purchaseVerification = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveVPOS, 'sha512');

        /** @var User $user */
        $user = $request->user();
        $codCardHolderCommerce = $user->id;
        $userPaymeCode = $tokenUsuario;

        return view('web.shop.confirmation', compact(
            'user',
            'buy',
            'acquirerId',
            'codCardHolderCommerce',
            'idCommerce',
            'purchaseAmount',
            'purchaseOperationNumber',
            'purchaseVerification',
            'purchaseCurrencyCode',
            'userPaymeCode',
            'horasEnvioDiario'
        ));
    }

    public function confirmation(Request $request, $buyHashId)
    {
        $buy = Buy::findByHash($buyHashId);

        abort_if(\Auth::user()->cant('view', $buy), 403);
        //abort_if($buy->tipo_pago_id == config('constants.TIPO_PAGO_MEMBRESIA_ID'), 403);

        // Comprobando si el pago fue realizado correctamente
        $paymeCode = $buy->payments->first()->auth_result ?? null;
        //$esCompraOnline = $buy->tipo_pago_id == config('constants.TIPO_PAGO_ONLINE') ? true : false;
        $tokenUsuario = null;

        if ($paymeCode != '00') {
            $buy->buy_number = $this->getCurrentBuyNumber();
            $buy->save();

            $tokenUsuario = $this->getOrRegisterInWallet($request);

            $acquirerId = env('PAYME_ACQUIRER_ID');
            $idCommerce = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? env('PAYME_COMMERCE_ID') : env('PAYME_COMMERCE_ID_ENGLISH');
            $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
            $purchaseAmount = intval(number_format($buy->total, 2) * 100);
            $purchaseCurrencyCode = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? '840' : '604';
            $claveVPOS = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? env('PAYME_VPOS_COMMERCE_SECRET') : env('PAYME_VPOS_COMMERCE_SECRET_ENGLISH');

            $purchaseVerification = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveVPOS, 'sha512');
        }

        /** @var User $user */
        $user = $request->user();
        $codCardHolderCommerce = $user->id;
        $userPaymeCode = $tokenUsuario;

        return view('comun.confirmacion', compact(
            'user',
            'codCardHolderCommerce',
            'idCommerce',
            'purchaseAmount',
            'purchaseOperationNumber',
            'purchaseVerification',
            'purchaseCurrencyCode',
            'userPaymeCode',
            'paymeCode',
            'acquirerId',
            'buy'
        ));
    }

    public function pagoPaymeConfirmacionPost(Request $request)
    {
        /** @var Buy $buy */
        $buy = Buy::whereUserId($request->user()->id)->latest('id')->firstOrFail();

        //event(new IntentoPagoRealizado($request->user(), $request->all()));

        $payment = new Payment;
        $payment->buy()->associate($buy);
        $payment->auth_result = $request->input('authorizationResult');
        $payment->auth_code = $request->input('authorizationCode');
        $payment->error_code = $request->input('errorCode');
        $payment->card_brand = $request->input('brand');
        $payment->reference = $request->input('paymentReferenceCode');
        $payment->verification = $request->input('purchaseVerification');

        if ($request->input('authorizationResult') == '00') {
            $payment->auth_result_text = 'Operación Autorizada';
            $buy->payed = now()->toDateTimeString();
            $buy->save();
        } elseif ($request->input('authorizationResult') == '01') {
            $payment->auth_result_text = 'Operación Denegada';
        } elseif ($request->input('authorizationResult') == '05') {
            $payment->auth_result_text = 'Operación Rechazada';
        }

        $payment->save();

        return redirect()->route('compra.confirmacion', $buy->hash_id);
    }

    public function pagoPaymeConfirmacion(Request $request)
    {
        $buy = Buy::whereUserId($request->user()->id)->latest('id')->firstOrFail();

        return redirect()->route('compra.confirmacion', $buy->hash_id);
    }


    /**
     * Get or register the user wallen token
     *
     * @param Request $request
     * @return bool
     */
    private function getOrRegisterInWallet(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        if (!is_null($user->payme_wallet_token)) {
            return $user->payme_wallet_token;
        }

        try {
            $client = new \SoapClient(env('PAYME_URL_PASARELA'), [
                'stream_context' => stream_context_create([
                    'http' => ['user_agent' => 'PHPSoapClient'],
                ]),
                'cache_wsdl'     => WSDL_CACHE_NONE,
            ]);

            //Creación de Arreglo para el almacenamiento y envío de parametros.
            $idEntCommerce = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? env('PAYME_WALLET_COMMERCE_ID') : env('PAYME_WALLET_COMMERCE_ID_ENGLISH');
            $codCardHolderCommerce = $user->id;
            $claveSecretaWallet = \Session::get('BIPOLAR_CURRENCY') === 'USD' ? env('PAYME_WALLET_COMMERCE_SECRET') : env('PAYME_WALLET_COMMERCE_SECRET_ENGLISH');
            $emailUser = $user->email;
            $registerVerification = openssl_digest($idEntCommerce . $codCardHolderCommerce . $emailUser . $claveSecretaWallet, 'sha512');

            $params = array(
                'idEntCommerce'         => $idEntCommerce,
                'codCardHolderCommerce' => $codCardHolderCommerce,
                'names'                 => $user->name,
                'lastNames'             => $user->lastname ?? $user->name,
                'mail'                  => $emailUser,
                'registerVerification'  => $registerVerification,
                /*'reserved1'             => '',
                'reserved2'             => '',
                'reserved3'             => '',*/
            );

            $paymeUser = $client->RegisterCardHolder($params);

            //Consumo del metodo RegisterCardHolder
            return $paymeUser->codAsoCardHolderWallet;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @return int|mixed
     */
    private function getCurrentBuyNumber()
    {
        /** @var Settings $setting */
        $setting = Settings::first();

        // Primera numero de operacion
        if (empty($setting->current_buy)) {
            return 1;
        }

        $setting->current_buy = $setting->current_buy + 1;
        $setting->save();

        return $setting->current_buy;
    }

    /**
     * Return total for shipping
     *
     * @param Buy $buy
     * @return float
     */
    private function calculateShippingFee(Buy $buy) : float
    {
        if ($buy->showroom) {
            return 0;
        }

        $shipping = Shipping::with(['includes', 'excludes'])
            ->whereHas('includes', function ($whereIncludes) use ($buy) {
                /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                $whereIncludes->where('country_state_id', $buy->shipping_address->country_state_id);
            })
            ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($buy) {
                /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                $whereDoesntHaveExcluded->where('country_state_id', $buy->shipping_address->country_state_id)
                    ->orWhere('country_id', $buy->shipping_address->country_state->country_id);
            })
            ->whereActive(true)
            ->first();

        if (is_null($shipping)) {
            $shipping = Shipping::with(['includes', 'excludes'])
                ->whereHas('includes', function ($whereIncludes) use ($buy) {
                    /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                    $whereIncludes->where('country_id', $buy->shipping_address->country_state->country_id);
                })
                ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($buy) {
                    /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                    $whereDoesntHaveExcluded->where('country_state_id', $buy->shipping_address->country_state_id)
                        ->orWhere('country_id', $buy->shipping_address->country_state->country_id);
                })
                ->whereActive(true)
                ->first();
        }

        if (is_null($shipping)) {
            return 0;
        }

        $totalWeight = $buy->details->sum(function ($detail) {
            /** @var BuyDetail $detail */
            return $detail->product->weight ?? 0;
        });

        $dolarsPrice = \Session::get('BIPOLAR_CURRENCY') === 'USD';

        switch ($totalWeight) {
            case $totalWeight <= 0.2: $totalShipping = ($dolarsPrice ? $shipping->g200_dolar : $shipping->g200); break;
            case $totalWeight <= 0.5: $totalShipping = ($dolarsPrice ? $shipping->g500_dolar : $shipping->g500); break;
            case $totalWeight <= 1: $totalShipping = ($dolarsPrice ? $shipping->kg1_dolar : $shipping->kg1); break;
            case $totalWeight <= 2: $totalShipping = ($dolarsPrice ? $shipping->kg2_dolar : $shipping->kg2); break;
            case $totalWeight <= 3: $totalShipping = ($dolarsPrice ? $shipping->kg3_dolar : $shipping->kg3); break;
            case $totalWeight <= 4: $totalShipping = ($dolarsPrice ? $shipping->kg4_dolar : $shipping->kg4); break;
            case $totalWeight <= 5: $totalShipping = ($dolarsPrice ? $shipping->kg5_dolar : $shipping->kg5); break;
            case $totalWeight <= 6: $totalShipping = ($dolarsPrice ? $shipping->kg6_dolar : $shipping->kg6); break;
            case $totalWeight <= 7: $totalShipping = ($dolarsPrice ? $shipping->kg7_dolar : $shipping->kg7); break;
            case $totalWeight <= 8: $totalShipping = ($dolarsPrice ? $shipping->kg8_dolar : $shipping->kg8); break;
            case $totalWeight <= 9: $totalShipping = ($dolarsPrice ? $shipping->kg9_dolar : $shipping->kg9); break;
            case $totalWeight <= 10: $totalShipping = ($dolarsPrice ? $shipping->kg10_dolar : $shipping->kg10); break;
            default: $totalShipping = 0; break;
        }

        if ($dolarsPrice) {
            $buy->shipping_fee_dolar = $totalShipping;
            $buy->total = floatval($buy->subtotal + $totalShipping);
        } else {
            $buy->shipping_fee = $totalShipping;
            $buy->total = floatval($buy->subtotal + $totalShipping);
        }
        $buy->save();

        return $buy->shipping_fee;
    }
}
