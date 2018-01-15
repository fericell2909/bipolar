<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Photo extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'hash_id' => $this->hash_id,
            'url'     => $this->url,
            'order'   => $this->order,
        ];
    }
}
