<?php

namespace App\Http\Controllers\Web;

use App\Events\SaleSuccessful;
use App\Models\Buy;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymeController extends Controller
{
    private function generateStepStatuses(Buy $buy): array
    {
        $statuses = [
            config('constants.BUY_INCOMPLETE_STATUS') => $buy->latestStatus(config('constants.BUY_INCOMPLETE_STATUS')),
            config('constants.BUY_PROCESSING_STATUS') => $buy->latestStatus(config('constants.BUY_PROCESSING_STATUS')),
            config('constants.BUY_CULMINATED_STATUS') => $buy->latestStatus(config('constants.BUY_CULMINATED_STATUS')),
        ];

        if ($buy->showroom) {
            $statuses[config('constants.BUY_PICKUP_STATUS')] = $buy->latestStatus(config('constants.BUY_PICKUP_STATUS'));
        } else {
            $statuses[config('constants.BUY_SENT_STATUS')] = $buy->latestStatus(config('constants.BUY_SENT_STATUS'));
            $statuses[config('constants.BUY_TRANSIT_STATUS')] = $buy->latestStatus(config('constants.BUY_TRANSIT_STATUS'));
        }

        return $statuses;
    }

    public function pagoPayme(Request $request, $buyId)
    {
        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);

        $this->authorize('view', $buy);

        $buy->load(['details.product.photos', 'details.stock.size', 'details.product']);

        $buy->buy_number = $this->getCurrentBuyNumber();
        $buy->save();

        $tokenUsuario = $this->getOrRegisterInWallet($request, $buy->currency);

        $acquirerId = config('payme.acquirer_id');
        $idCommerce = $buy->currency === 'USD' ? config('payme.commerce_usd_id') : config('payme.commerce_pen_id');
        $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
        $purchaseAmount = $buy->getPaymeFormattedNumber();
        $purchaseCurrencyCode = $buy->currency === 'USD' ? '840' : '604';
        $claveVPOS = $buy->currency === 'USD' ? config('payme.vpos_commerce_usd_secret') : config('payme.vpos_commerce_pen_secret');

        $purchaseVerification = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveVPOS, 'sha512');

        /** @var User $user */
        $user = $request->user();
        $codCardHolderCommerce = $user->id;
        $userPaymeCode = $tokenUsuario;

        $buyStatuses = $this->generateStepStatuses($buy);

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
            'buyStatuses'
        ));
    }

    public function confirmation(Request $request, $buyId = null)
    {
        /** @var Buy $buy */
        if ($buyId) {
            $buy = Buy::findOrFail($buyId);
        } else {
            $buy = Buy::whereUserId($request->user()->id)->latest('id')->firstOrFail();
        }

        $this->authorize('view', $buy);
        $buy->load(['details.product.photos', 'details.stock.size', 'details.product']);

        // Comprobando si el pago fue realizado correctamente
        $paymeCode = $buy->payments->sortByDesc('id')->first()->auth_result ?? null;
        $tokenUsuario = null;

        if ($paymeCode != '00') {
            $buy->buy_number = $this->getCurrentBuyNumber();
            $buy->save();

            $tokenUsuario = $this->getOrRegisterInWallet($request, $buy->currency);

            $acquirerId = config('payme.acquirer_id');
            $idCommerce = $buy->currency === 'USD' ? config('payme.commerce_usd_id') : config('payme.commerce_pen_id');
            $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
            $purchaseAmount = $buy->getPaymeFormattedNumber();
            $purchaseCurrencyCode = $buy->currency === 'USD' ? '840' : '604';
            $claveVPOS = $buy->currency === 'USD' ? config('payme.vpos_commerce_usd_secret') : config('payme.vpos_commerce_pen_secret');

            $purchaseVerification = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveVPOS, 'sha512');
        } elseif ($paymeCode === "00") {
            return view('web.shop.confirmation_payed', compact('buy'));
        }

        /** @var User $user */
        $user = $request->user();
        $codCardHolderCommerce = $user->id;
        $userPaymeCode = $tokenUsuario;

        $buyStatuses = $this->generateStepStatuses($buy);

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
            'paymeCode',
            'buyStatuses'
        ));
    }

    /**
     * Si por algún motivo se repiten las compras consultar la dirección web de respuesta con Payme
     * a veces hace redirecciones de http a https o de www a no-www
     */
    public function reconfirmationPost(Request $request)
    {
        /** @var Buy $buy */
        $buy = Buy::whereUserId($request->user()->id)->latest('id')->with('payments')->firstOrFail();

        // Redirect if has a successful payment (prevent many payments)
        $paymeCode = $buy->payments->sortByDesc('id')->first()->auth_result ?? null;
        if ($paymeCode === "00") {
            return redirect(route('reconfirmation', $buy->id));
        }

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
            $buy->setStatus(config('constants.BUY_PROCESSING_STATUS'));
            if ($buy->showroom) {
                $buy->setStatus(config('constants.BUY_PICKUP_STATUS'));
            }
            \Log::info('Payment created for buy', ['payment' => $payment]);
            event(new SaleSuccessful($buy));
        } elseif ($request->input('authorizationResult') == '01') {
            $payment->auth_result_text = 'Operación Denegada';
        } elseif ($request->input('authorizationResult') == '05') {
            $payment->auth_result_text = 'Operación Rechazada';
        }

        $payment->save();

        return redirect(route('reconfirmation', $buy->id));
    }

    public function reconfirmation(Request $request)
    {
        $buy = Buy::whereUserId($request->user()->id)->latest('id')->firstOrFail();

        return redirect()->route('confirmation', $buy->id);
    }


    /**
     * Get or register the user wallen token
     *
     * @param Request $request
     * @param string $currency
     * @return bool
     */
    private function getOrRegisterInWallet(Request $request, string $currency)
    {
        /** @var User $user */
        $user = $request->user();
        if (!is_null($user->payme_wallet_token)) {
            return $user->payme_wallet_token;
        }

        try {
            $client = new \SoapClient(config('payme.url_pasarela'), [
                'stream_context' => stream_context_create([
                    'http' => ['user_agent' => 'PHPSoapClient'],
                ]),
                'cache_wsdl'     => WSDL_CACHE_NONE,
            ]);

            //Creación de Arreglo para el almacenamiento y envío de parametros.
            $idEntCommerce = $currency === 'USD' ? config('payme.wallet_usd_commerce_id') : config('payme.wallet_pen_commerce_id');
            $codCardHolderCommerce = $user->id;
            $claveSecretaWallet = $currency === 'USD' ? config('payme.wallet_usd_commerce_secret') : config('payme.wallet_pen_commerce_secret');
            $emailUser = $user->email;
            $registerVerification = openssl_digest($idEntCommerce . $codCardHolderCommerce . $emailUser . $claveSecretaWallet, 'sha512');

            $params = array(
                'idEntCommerce'         => $idEntCommerce,
                'codCardHolderCommerce' => $codCardHolderCommerce,
                'names'                 => $user->name,
                'lastNames'             => $user->lastname ?? $user->name,
                'mail'                  => $emailUser,
                'registerVerification'  => $registerVerification,
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
        if (intval($setting->current_buy) === 0) {
            $setting->current_buy = 1;
        } else {
            $setting->current_buy = $setting->current_buy + 1;
            $setting->save();
        }

        $setting->save();

        return $setting->current_buy;
    }
}
