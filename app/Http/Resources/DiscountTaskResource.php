<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Type as TypeResource;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\Subtype as SubtypeResource;

class DiscountTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\DiscountTask $discountTask */
        $discountTask = $this;

        return [
            'id'                    => (int)$discountTask->id,
            'name'                  => $discountTask->name,
            'begin'                 => $discountTask->begin->format('d-m-Y'),
            'end'                   => $discountTask->end->format('d-m-Y'),
            'discount_pen'          => $discountTask->discount_pen,
            'discount_usd'          => $discountTask->discount_usd,
            'product_types'         => $discountTask->product_types ?? [],
            'products'              => $discountTask->products ?? [],
            'product_subtypes'      => $discountTask->product_subtypes ?? [],
            'products_full'         => $this->when(!is_null($discountTask->products_model), function () use ($discountTask) {
                return ProductResource::collection($discountTask->products_model);
            }),
            'product_types_full'    => $this->when(!is_null($discountTask->types_model), function () use ($discountTask) {
                return TypeResource::collection($discountTask->types_model);
            }),
            'product_subtypes_full' => $this->when(!is_null($discountTask->subtypes_model), function () use ($discountTask) {
                return SubtypeResource::collection($discountTask->subtypes_model);
            }),
            'available'             => (bool)$discountTask->available,
            'executed'              => (bool)$discountTask->executed,
            'edit_route'            => route('products.multiple-discounts.edit', $discountTask->id),
        ];
    }
}
