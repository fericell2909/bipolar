<?php

namespace App\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Coupon $coupon */
        $coupon = $this;

        return [
            'id'            => $this->when(\Auth::guard('admin')->check(), $coupon->id),
            'code'          => $coupon->code,
            'product_types' => $coupon->product_types ?? [],
            'products'      => $coupon->products ?? [],
        ];
    }
}
