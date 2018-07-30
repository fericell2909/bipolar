<?php

namespace App\Http\Controllers\Web;

use App\Http\Services\BSale;
use App\Mail\BuyConfirmation;
use App\Models\Buy;
use App\Models\Payment;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymeController extends Controller
{
    public function pagoPayme(Request $request, $buyId)
    {
        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);

        $this->authorize('view', $buy);

        $buy->load(['details.product.photos', 'details.stock.size', 'details.product']);

        $buy->buy_number = $this->getCurrentBuyNumber();
        $buy->save();

        $tokenUsuario = $this->getOrRegisterInWallet($request, $buy->currency);

        $acquirerId = env('PAYME_ACQUIRER_ID');
        $idCommerce = $buy->currency === 'USD' ? env('PAYME_COMMERCE_ID_ENGLISH') : env('PAYME_COMMERCE_ID');
        $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
        $purchaseAmount = intval($buy->total * 100);
        $purchaseCurrencyCode = $buy->currency === 'USD' ? '840' : '604';
        $claveVPOS = $buy->currency === 'USD' ? env('PAYME_VPOS_COMMERCE_SECRET_ENGLISH') : env('PAYME_VPOS_COMMERCE_SECRET');

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
            'userPaymeCode'
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
        //abort_if($buy->tipo_pago_id == config('constants.TIPO_PAGO_MEMBRESIA_ID'), 403);

        // Comprobando si el pago fue realizado correctamente
        $paymeCode = $buy->payments->sortByDesc('id')->first()->auth_result ?? null;
        //$esCompraOnline = $buy->tipo_pago_id == config('constants.TIPO_PAGO_ONLINE') ? true : false;
        $tokenUsuario = null;

        if ($paymeCode != '00') {
            $buy->buy_number = $this->getCurrentBuyNumber();
            $buy->save();

            $tokenUsuario = $this->getOrRegisterInWallet($request, $buy->currency);

            $acquirerId = env('PAYME_ACQUIRER_ID');
            $idCommerce = $buy->currency === 'USD' ? env('PAYME_COMMERCE_ID_ENGLISH') : env('PAYME_COMMERCE_ID');
            $purchaseOperationNumber = sprintf('%06d', $buy->buy_number);
            $purchaseAmount = intval(number_format($buy->total, 2) * 100);
            $purchaseCurrencyCode = $buy->currency === 'USD' ? '840' : '604';
            $claveVPOS = $buy->currency === 'USD' ? env('PAYME_VPOS_COMMERCE_SECRET_ENGLISH') : env('PAYME_VPOS_COMMERCE_SECRET');

            $purchaseVerification = openssl_digest($acquirerId . $idCommerce . $purchaseOperationNumber . $purchaseAmount . $purchaseCurrencyCode . $claveVPOS, 'sha512');
        } elseif ($paymeCode === "00") {
            return view('web.shop.confirmation_payed', compact('buy'));
        }

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
            'paymeCode'
        ));
    }

    public function reconfirmationPost(Request $request)
    {
        /** @var Buy $buy */
        $buy = Buy::whereUserId($request->user()->id)->latest('id')->firstOrFail();

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
            $buy->setStatus(config('constants.BUY_PROCESSING_STATUS'), 'Pago exitoso');
            \Mail::to($request->user())->send(new BuyConfirmation($buy));
            $response = BSale::documentCreate($buy);
            if ($response->isSuccess()) {
                $content = $response->json();
                $buy->bsale_document_url = array_get($content, 'urlPdf');
                $buy->save();
            } else {
                \Log::warning($response->body());
            }
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
            $client = new \SoapClient(env('PAYME_URL_PASARELA'), [
                'stream_context' => stream_context_create([
                    'http' => ['user_agent' => 'PHPSoapClient'],
                ]),
                'cache_wsdl'     => WSDL_CACHE_NONE,
            ]);

            //Creación de Arreglo para el almacenamiento y envío de parametros.
            $idEntCommerce = $currency === 'USD' ? env('PAYME_WALLET_COMMERCE_ID') : env('PAYME_WALLET_COMMERCE_ID_ENGLISH');
            $codCardHolderCommerce = $user->id;
            $claveSecretaWallet = $currency === 'USD' ? env('PAYME_WALLET_COMMERCE_SECRET') : env('PAYME_WALLET_COMMERCE_SECRET_ENGLISH');
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
