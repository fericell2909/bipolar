<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SizeCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($size) {
                /** @var \App\Models\Size $size */
                return [
                    'hash_id' => $size->hash_id,
                    'name'    => $size->name,
                ];
            }),
        ];
    }
}
