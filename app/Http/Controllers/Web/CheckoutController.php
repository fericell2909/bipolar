<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartDetail;
use App\Models\Country;
use App\Models\Address;
use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Shipping;
use App\Models\Stock;
use Illuminate\Http\Request;
use Zttp\Zttp;

class CheckoutController extends Controller
{
    private $token;

    public function __construct()
    {
        $this->token = env('BSALE_TOKEN');
    }

    public function checkout()
    {
        if (\CartBipolar::count() === 0) {
            return redirect(route('shop'));
        }

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

        return view('web.shop.checkout', compact('cart', 'countries', 'billingAddresses', 'shippingAddresses'));
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
                if ($cartDetail->stock->bsale_stock_id) {
                    $quantity = $this->updateStockInBsale($cartDetail->stock, $cartDetail->quantity, $buy->id);
                }
                $buyDetail->stock->quantity -= $quantity;
                $buyDetail->stock->save();
            }
            $buyDetail->quantity = $cartDetail->quantity;
            $buyDetail->total = \Session::get('BIPOLAR_CURRENCY', 'USD') === 'USD' ? $cartDetail->total_dolar : $cartDetail->total;
            $buyDetail->save();
        }

        \CartBipolar::destroy();

        $buy->setStatus(config('constants.BUY_INCOMPLETE_STATUS'));

        if ($request->filled('showroom_pick')) {
            $buy->showroom = true;
            $buy->save();
        } else {
            $this->calculateShippingFee($buy);
        }

        return redirect()->route('confirmation', $buy->id);
    }

    /**
     * @param Stock $stock
     * @param int $quantity
     * @return int|mixed
     */
    private function updateStockInBsale(Stock $stock, int $quantity, int $buyId)
    {
        // get the bsale stock and sale the quantity
        /** @var \Zttp\ZttpResponse $response */
        $response = Zttp::withHeaders(['access_token' => $this->token])
            ->get("https://api.bsale.cl/v1/stocks/{$stock->bsale_stock_id}.json");

        if (!$response->isSuccess()) {
            return null;
        }

        /** @link https://github.com/gmontero/API-Bsale/wiki/Stocks#get-un-stock */
        $content = $response->json();

        // if the quantity is >= stock bsale qty, sell all
        if ($content['quantityAvailable'] < $quantity) {
            $quantity = $content['quantityAvailable'];
        }

        $dataConsume = [
            'note'     => "Venta por Web compra #{$buyId}",
            'officeId' => data_get($content, 'office.id'),
            'details'  => [
                [
                    'quantity'  => $quantity,
                    'variantId' => data_get($content, 'variant.id'),
                ],
            ],
        ];

        // create stock consume
        /** @var \Zttp\ZttpResponse $responseConsume */
        $responseConsume = Zttp::asJson()->withHeaders(['access_token' => $this->token])
            ->post('https://api.bsale.cl/v1/stocks/consumptions.json', $dataConsume);

        if (!$responseConsume->isSuccess()) {
            return null;
        }

        // update the quantity in the stock
        return $quantity;
    }

    /**
     * Return total for shipping
     *
     * @param Buy $buy
     * @return float
     */
    private function calculateShippingFee(Buy $buy): float
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
            case $totalWeight <= 0.2:
                $totalShipping = ($dolarsPrice ? $shipping->g200_dolar : $shipping->g200);
                break;
            case $totalWeight <= 0.5:
                $totalShipping = ($dolarsPrice ? $shipping->g500_dolar : $shipping->g500);
                break;
            case $totalWeight <= 1:
                $totalShipping = ($dolarsPrice ? $shipping->kg1_dolar : $shipping->kg1);
                break;
            case $totalWeight <= 2:
                $totalShipping = ($dolarsPrice ? $shipping->kg2_dolar : $shipping->kg2);
                break;
            case $totalWeight <= 3:
                $totalShipping = ($dolarsPrice ? $shipping->kg3_dolar : $shipping->kg3);
                break;
            case $totalWeight <= 4:
                $totalShipping = ($dolarsPrice ? $shipping->kg4_dolar : $shipping->kg4);
                break;
            case $totalWeight <= 5:
                $totalShipping = ($dolarsPrice ? $shipping->kg5_dolar : $shipping->kg5);
                break;
            case $totalWeight <= 6:
                $totalShipping = ($dolarsPrice ? $shipping->kg6_dolar : $shipping->kg6);
                break;
            case $totalWeight <= 7:
                $totalShipping = ($dolarsPrice ? $shipping->kg7_dolar : $shipping->kg7);
                break;
            case $totalWeight <= 8:
                $totalShipping = ($dolarsPrice ? $shipping->kg8_dolar : $shipping->kg8);
                break;
            case $totalWeight <= 9:
                $totalShipping = ($dolarsPrice ? $shipping->kg9_dolar : $shipping->kg9);
                break;
            case $totalWeight <= 10:
                $totalShipping = ($dolarsPrice ? $shipping->kg10_dolar : $shipping->kg10);
                break;
            default:
                $totalShipping = 0;
                break;
        }

        $buy->shipping_fee = $totalShipping;
        $buy->total = floatval($buy->subtotal + $totalShipping);
        $buy->save();

        return $buy->shipping_fee ?? 0;
    }
}
