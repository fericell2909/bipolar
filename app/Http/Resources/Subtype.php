<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Subtype extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Subtype $subtype */
        $subtype = $this;

        return [
            'id'      => $this->when(\Auth::guard('admin')->check(), $subtype->id),
            'hash_id' => $subtype->hash_id,
            'name'    => $subtype->name,
            'slug'    => $subtype->slug,
        ];
    }
}
