<?php

namespace App\Http\Resources;

use App\Models\Stock;
use Illuminate\Http\Resources\Json\Resource;

class AdminStockResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Stock $stock */
        $stock = $this;

        return [
            'id'        => $stock->id,
            'size_name' => $stock->size->name ?? '--',
            'quantity'  => $stock->quantity,
        ];
    }
}
