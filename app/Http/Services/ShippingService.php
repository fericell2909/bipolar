<?php

namespace App\Http\Services;

use App\Models\Address;
use App\Models\Shipping;

class ShippingService
{
    /**
     * Get a shipping address if exists from the database with the current shipping prices
     *
     * @param Address $address
     * @return Shipping|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public static function getShippingByAddress(Address $address)
    {
        return Shipping::with(['includes', 'excludes'])
            ->whereHas('includes', function ($whereIncludes) use ($address) {
                /** @var \Illuminate\Database\Query\Builder $whereIncludes */
                $whereIncludes->where('country_state_id', $address->country_state_id);
            })
            ->whereDoesntHave('excludes', function ($whereDoesntHaveExcluded) use ($address) {
                /** @var \Illuminate\Database\Query\Builder $whereDoesntHaveExcluded */
                $whereDoesntHaveExcluded->where('country_state_id', $address->country_state_id)
                    ->orWhere('country_id', $address->country_state->country_id);
            })
            ->whereActive(true)
            ->first();
    }

    /**
     * @param Shipping $shipping
     * @param float $totalWeight
     * @param string $currency
     * @return float
     */
    public static function calculateShippingByWeight(Shipping $shipping, float $totalWeight, string $currency) : float
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