<?php

namespace App\Http\Controllers\Web;

use App\Mail\BuyConfirmation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Settings;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (\CartBipolar::count() === 0) {
            return redirect(route('shop'));
        }

        $countries = Country::orderBy('name')->get()->mapWithKeys(function ($country) {
            return [$country->id => mb_strtoupper($country->name)];
        })->toArray();
        $addresses = Address::whereUserId(\Auth::id())->with('address_type', 'country_state')->get();

        $billingAddresses = $addresses->filter(function ($address) {
            return $address->address_type->name == 'billing';
        });
        $shippingAddresses = $addresses->filter(function ($address) {
            return $address->address_type->name == 'shipping';
        });

        return view('web.shop.checkout', compact('countries', 'billingAddresses', 'shippingAddresses'));
    }

    public function buy()
    {
        if (\CartBipolar::count() === 0) {
            return redirect()->back();
        }

        $billingAddress = Address::whereAddressTypeId(config('constants.ADDRESS_TYPE_BILLING_ID'))
            ->where('user_id', \Auth::id())
            ->where('main', true)
            ->first();

        if (is_null($billingAddress)) {
            flash()->error('No hay una dirección de pago registrada');
            return redirect()->back();
        }

        $shippingAddress = Address::whereAddressTypeId(config('constants.ADDRESS_TYPE_SHIPPING_ID'))
            ->where('user_id', \Auth::id())
            ->where('main', true)
            ->first();

        if (is_null($shippingAddress)) {
            /** @var Address $shippingAddress */
            $shippingAddress = $billingAddress->replicate();
            $shippingAddress->user_id = \Auth::id();
            $shippingAddress->address_type_id = config('constants.ADDRESS_TYPE_SHIPPING_ID');
            $shippingAddress->push();
        }

        $buy = new Buy;
        $buy->user()->associate(\Auth::user());
        $buy->billing_address()->associate($billingAddress);
        $buy->shipping_address()->associate($shippingAddress);
        $buy->subtotal = \CartBipolar::last()->subtotal;
        $buy->total = \CartBipolar::last()->total;
        $buy->total_dolar = \CartBipolar::last()->total_dolar;

        if (!$buy->save()) {
            return abort(500);
        }

        foreach (\CartBipolar::content() as $cartDetail) {
            $buyDetail = new BuyDetail;
            $buyDetail->buy()->associate($buy);
            $buyDetail->product()->associate($cartDetail->product);
            if ($cartDetail->stock) {
                $buyDetail->stock()->associate($cartDetail->stock);
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = $cartDetail->total;
            $buyDetail->total_dolar = $cartDetail->total_dolar;
            $buyDetail->save();
        }

        \CartBipolar::destroy();

        \Mail::to(\Auth::user())->send(new BuyConfirmation($buy));

        return redirect()->route('confirmation', $buy->id);
    }

    public function confirmation($buyId)
    {
        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);
        $setting = Settings::first();

        $setting->current_buy++;
        $setting->save();
        $referenceCode = now()->format('dmY') . "C" . $setting->current_buy;

        $payuSignatureCode = $this->payuSignatureCode($buy, $referenceCode);

        abort_if($buy->user_id !== \Auth::id(), 403);

        // todo: remove this is only for browser email testing
        // return new BuyConfirmation($buy);

        return view('web.shop.confirmation', compact('buy', 'payuSignatureCode', 'referenceCode'));
    }

    private function payuSignatureCode(Buy $buy, $referenceCode)
    {
        return env('BIPOLAR_PAYU_APIKEY') . "~" . env('BIPOLAR_PAYU_MERCHANTID') . "~" . $referenceCode . "~" . $buy->total_session . "~" . \Session::get('BIPOLAR_CURRENCY', 'USD');
    }
}
