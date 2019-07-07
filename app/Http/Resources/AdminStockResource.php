<?php

namespace App\Http\Resources;

use App\Models\Stock;
use Illuminate\Http\Resources\Json\Resource;

class AdminStockResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Stock $stock */
        $stock = $this;

        return [
            'id'              => $stock->id,
            'bsale_stock_id'  => $stock->bsale_stock_id,
            'bsale_stock_ids' => $stock->bsale_stock_ids ?? [],
            'size_name'       => $stock->size->name ?? '--',
            'quantity'        => $stock->quantity,
        ];
    }
}
