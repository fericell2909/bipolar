<?php

namespace App\Http\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Shipping;
use Illuminate\Support\Collection;

class ShippingService
{
    public static function calculateShippingByCart(Cart $cart, Collection $addresses, string $currency)
    {
        $shipping = null;
        $totalWeight = $cart->details
            ->reject(function ($detail) {
                /** @var \App\Models\CartDetail $detail */
                return boolval($detail->product->free_shipping);
            })
            ->sum(function ($detail) {
                /** @var \App\Models\CartDetail $detail */
                return $detail->product->weight ?? 0;
            });
        $shippingFee = 0;

        $billingAddresses = $addresses->filter(function ($address) {
            return $address->address_type->name === 'billing';
        });
        $shippingAddresses = $addresses->filter(function ($address) {
            return $address->address_type->name === 'shipping';
        });

        $activeShippings = Shipping::whereActive(true)->count();

        if ($activeShippings > 0) {
            if ($shippingAddresses->count() >= 1) {
                $shipping = self::getShippingByAddresses($shippingAddresses);
                $shippingFee = self::calculateShippingByWeight($shipping, $totalWeight, $currency);
            } elseif ($shippingAddresses->count() === 0 && $billingAddresses->count() >= 1) {
                $shipping = self::getShippingByAddresses($billingAddresses);
                $shippingFee = self::calculateShippingByWeight($shipping, $totalWeight, $currency);
            }
        }

        $showroomPickup = !is_null($shipping) ? boolval($shipping->allow_showroom) : false;
        $shippingFeeAsText = $currency === 'USD' ? "$ {$shippingFee}" : "S/ {$shippingFee}";

        return [
            $shipping->title ?? 'General',
            $shippingFeeAsText,
            $showroomPickup,
            $shipping->is_dni_required ?? false,
        ];
    }

    /**
     * Get a shipping address if exists from the database with the current shipping prices
     *
     * @param Address $address
     * @return Shipping|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public static function getShippingByAddress(Address $address)
    {
        $shipping = Shipping::with(['includes', 'excludes'])
            ->whereHas('includes', function ($whereIncludes) use ($address) {
                /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                $whereIncludes->where('country_state_id', $address->country_state_id)
                    ->orWhere('country_id', $address->country_state->country_id);
            })
            ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($address) {
                /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                $whereDoesntHaveExcluded->where('country_state_id', $address->country_state_id)
                    ->orWhere('country_id', $address->country_state->country_id);
            })
            ->whereActive(true)
            ->first();

        if (is_null($shipping)) {
            $shipping = Shipping::with(['includes', 'excludes'])
                ->whereHas('includes', function ($whereIncludes) use ($address) {
                    /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                    $whereIncludes->where('all_countries', true);
                })
                ->whereActive(true)
                ->first();
        }

        if (is_null($shipping)) {
            $shipping = Shipping::whereActive(true)->first();
        }


        return $shipping;
    }

    /**
     * @param Collection $addresses
     * @return Shipping|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    private static function getShippingByAddresses(Collection $addresses)
    {
        /** @var Address $address */
        $address = $addresses->firstWhere('main', true);

        if (is_null($address)) {
            $address = $addresses->first();
        }

        return self::getShippingByAddress($address);
    }

    /**
     * @param Shipping $shipping
     * @param float $totalWeight
     * @param string $currency
     * @return float
     */
    public static function calculateShippingByWeight(Shipping $shipping, float $totalWeight, string $currency): float
    {
        if (is_null($shipping)) {
            return floatval(0);
        }

        $isDolarCurrency = $currency === 'USD';

        switch ($totalWeight) {
            case $totalWeight <= 0.2:
                $totalShipping = ($isDolarCurrency ? $shipping->g200_dolar : $shipping->g200);
                break;
            case $totalWeight <= 0.5:
                $totalShipping = ($isDolarCurrency ? $shipping->g500_dolar : $shipping->g500);
                break;
            case $totalWeight <= 1:
                $totalShipping = ($isDolarCurrency ? $shipping->kg1_dolar : $shipping->kg1);
                break;
            case $totalWeight <= 2:
                $totalShipping = ($isDolarCurrency ? $shipping->kg2_dolar : $shipping->kg2);
                break;
            case $totalWeight <= 3:
                $totalShipping = ($isDolarCurrency ? $shipping->kg3_dolar : $shipping->kg3);
                break;
            case $totalWeight <= 4:
                $totalShipping = ($isDolarCurrency ? $shipping->kg4_dolar : $shipping->kg4);
                break;
            case $totalWeight <= 5:
                $totalShipping = ($isDolarCurrency ? $shipping->kg5_dolar : $shipping->kg5);
                break;
            case $totalWeight <= 6:
                $totalShipping = ($isDolarCurrency ? $shipping->kg6_dolar : $shipping->kg6);
                break;
            case $totalWeight <= 7:
                $totalShipping = ($isDolarCurrency ? $shipping->kg7_dolar : $shipping->kg7);
                break;
            case $totalWeight <= 8:
                $totalShipping = ($isDolarCurrency ? $shipping->kg8_dolar : $shipping->kg8);
                break;
            case $totalWeight <= 9:
                $totalShipping = ($isDolarCurrency ? $shipping->kg9_dolar : $shipping->kg9);
                break;
            case $totalWeight <= 10:
                $totalShipping = ($isDolarCurrency ? $shipping->kg10_dolar : $shipping->kg10);
                break;
            default:
                $totalShipping = 0;
                break;
        }

        return floatval($totalShipping);
    }
}
