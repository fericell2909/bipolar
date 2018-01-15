<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class State extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\State|Resource $this */
        return [
            'hash_id' => $this->hash_id,
            'name'    => $this->name,
            'color'   => $this->color,
            'html'    => $this->getAdminHtml(),
        ];
    }
}
