<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ColorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($color) {
                /** @var \App\Models\Color $color */
                return [
                    'hash_id' => $color->hash_id,
                    'name' => $color->name,
                ];
            }),
        ];
    }
}
