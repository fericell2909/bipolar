<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Type;
use App\Models\Product;
use App\Models\Subtype;
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
        $types = Type::find($discountTask->product_types);
        $products = Product::find($discountTask->products);
        $subtypes = Subtype::find($discountTask->product_subtypes);

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
            'products_full'         => !is_null($products) ? ProductResource::collection($products) : [],
            'product_types_full'    => !is_null($types) ? TypeResource::collection($types) : [],
            'product_subtypes_full' => !is_null($subtypes) ? SubtypeResource::collection($subtypes): [],
            'available'             => (bool)$discountTask->available,
            'executed'              => (bool)$discountTask->executed,
        ];
    }
}
