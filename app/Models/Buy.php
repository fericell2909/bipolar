<?php

namespace App\Models;

use App\Traits\Hashable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\ModelStatus\HasStatuses;

/** @mixin \Eloquent */
class Buy extends Model
{
    use Hashable, HasStatuses;

    public function billing_address()
    {
        return $this->belongsTo(Address::class, 'billing_address_id')->withTrashed();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function shipping_address()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(BuyDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubtotalCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . intval($this->subtotal);
    }

    public function getTotalCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . intval($this->total);
    }

    public function getShippingFeeCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . number_format($this->shipping_fee, 2);
    }

    public function getDiscountCouponCurrencyAttribute()
    {
        $moneySign = $this->currency === 'PEN' ? 'S/' : '$';

        return "{$moneySign} " . number_format($this->discount_coupon, 2);
    }

    public function getCurrentStatusLabel()
    {
        return __("bipolar.buy.statuses." . $this->status);
    }

    public function getPaymeFormattedNumber()
    {
        return intval($this->total * 100);
    }

    /**
     * I could add this method to: https://github.com/spatie/laravel-model-status as PR
     *
     * @param Builder $builder
     * @param mixed ...$names
     */
    public function scopeOrCurrentStatus(Builder $builder, ...$names)
    {
        $names = is_array($names) ? Arr::flatten($names) : func_get_args();
        $builder
            ->orWhereHas(
                'statuses',
                function (Builder $query) use ($names) {
                    $query
                        ->whereIn('name', $names)
                        ->whereIn(
                            'id',
                            function (QueryBuilder $query) {
                                $query
                                    ->select(DB::raw('max(id)'))
                                    ->from($this->getStatusTableName())
                                    ->where('model_type', $this->getStatusModelType())
                                    ->whereColumn($this->getModelKeyColumnName(), $this->getQualifiedKeyName());
                            }
                        );
                }
            );
    }
}
