<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\BSale;
use App\Http\Services\ShippingService;
use App\Mail\BuyConfirmation;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Shipping;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (\CartBipolar::count() === 0) {
            return redirect(route('shop'));
        }

        /** @var Cart $cart */
        $cart = \CartBipolar::last();

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

        list($shipping, $shippingFee) = ShippingService::calculateShippingByCart($cart, $addresses, \Session::get('BIPOLAR_CURRENCY'));

        return view('web.shop.checkout', [
            'cart'              => $cart,
            'countries'         => $countries,
            'billingAddresses'  => $billingAddresses,
            'shippingAddresses' => $shippingAddresses,
            'shippingName'      => $shipping,
            'shippingFee'       => $shippingFee,
        ]);
    }

    public function buy(Request $request)
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
        $buy->subtotal = \CartBipolar::getSubtotalBySessionCurrency();
        $buy->total = \CartBipolar::getTotalBySessionCurrency();
        $buy->currency = \Session::get('BIPOLAR_CURRENCY', 'USD');

        abort_if(!$buy->save(), 500);

        foreach (\CartBipolar::content() as $cartDetail) {
            /** @var CartDetail $cartDetail */
            $buyDetail = new BuyDetail;
            $buyDetail->buy()->associate($buy);
            $buyDetail->product()->associate($cartDetail->product);
            if ($cartDetail->stock) {
                $buyDetail->stock()->associate($cartDetail->stock);
                $quantity = $cartDetail->quantity;
                $buyDetail->stock->quantity -= $quantity;
                $buyDetail->stock->save();
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = \Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $cartDetail->total_dolar : $cartDetail->total;
            $buyDetail->save();
        }

        \CartBipolar::destroy();

        $buy->setStatus(config('constants.BUY_INCOMPLETE_STATUS'));

        if ($request->input('showroom_pick') === 'free') {
            $buy->showroom = true;
            $buy->save();
        } elseif ($request->input('showroom_pick') === 'pay') {
            $this->shippingFeeByBuy($buy);
        }

        // The email only sends in not a production environment
        if (env('APP_ENV') !== 'production') {
            \Mail::to($request->user())->send(new BuyConfirmation($buy));
            $response = BSale::documentCreate($buy);
            if ($response->isSuccess()) {
                $content = $response->json();
                $buy->bsale_document_url = array_get($content, 'urlPdf');
                $buy->save();
            } else {
                \Log::warning(implode(',', $response->json()));
            }
        }

        return redirect()->route('confirmation', $buy->id);
    }

    /**
     * Return total for shipping
     *
     * @param Buy $buy
     * @return float
     */
    private function shippingFeeByBuy(Buy $buy): float
    {
        if ($buy->showroom) {
            return 0;
        }

        $shipping = ShippingService::getShippingByAddress($buy->shipping_address);

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

        $totalShipping = ShippingService::calculateShippingByWeight($shipping, floatval($totalWeight), \Session::get('BIPOLAR_CURRENCY'));

        $buy->shipping_fee = $totalShipping;
        $buy->total = floatval($buy->subtotal + $totalShipping);
        $buy->save();

        return $buy->shipping_fee ?? 0;
    }
}
