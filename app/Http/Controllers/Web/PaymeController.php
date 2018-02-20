<?php

namespace App\Http\Controllers\Web;

use App\Models\Buy;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymeController extends Controller
{
    public function pagoPayme(Request $request, $buyHashId)
    {
        $buy = Buy::findByHash($buyHashId);

        abort_if(\Auth::user()->cant('view', $buy), 403);
        //abort_if($buy->tipo_pago_id == config('constants.TIPO_PAGO_MEMBRESIA_ID'), 403);

        $buy->buy_number = $this->getCurrentBuyNumber();
        $buy->save();

        $tokenUsuario = $this->getOrRegisterInWallet($request);

        $acquirerId = env('PAYME_ACQUIRER_ID');
        $idCommerce = env('PAYME_COMMERCE_ID');
        $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
        $purchaseAmount = intval($buy->total_session * 100);
        // todo: cambiar el currency code (PEN / USD)
        $purchaseCurrencyCode = '604';
        $claveVPOS = env('PAYME_VPOS_COMMERCE_SECRET');

        $purchaseVerification = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveVPOS, 'sha512');

        /** @var User $user */
        $user = $request->user();
        $codCardHolderCommerce = $user->id;
        $userPaymeCode = $tokenUsuario;

        return view('comun.pagar-payme', compact(
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
            $idCommerce = env('PAYME_COMMERCE_ID');
            $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
            $purchaseAmount = intval(number_format($buy->total, 2) * 100);
            // todo: change the currency code
            $purchaseCurrencyCode = '604';
            $claveVPOS = env('PAYME_VPOS_COMMERCE_SECRET');

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
            // todo: change the buy status to payed
            //$buy->pay = true;
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
            $idEntCommerce = env('PAYME_WALLET_COMMERCE_ID');
            $codCardHolderCommerce = $user->id;
            $claveSecretaWallet = env('PAYME_WALLET_COMMERCE_SECRET');
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
}
