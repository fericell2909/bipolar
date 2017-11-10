<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $searchText = $request->input('search');

        $products = [];

        $products = Product::where('name', 'LIKE', "%{$searchText}%")
            ->with(['photos' => function ($withPhotos) { $withPhotos->orderBy('order'); }])
            ->get()
            ->transform($this->formatProduct())
            ->toArray();

        return response()->json(compact('products'));
    }

    public function recommendeds($productHashId)
    {
        $product = Product::findByHash($productHashId);
        $product->load('photos');

        $recommendeds = $product->recommendeds->transform($this->formatProduct())->toArray();

        return response()->json(compact('recommendeds'));
    }

    public function recommend($productParentHashId, $productRecommendedHashId)
    {
        $product = Product::findByHash($productParentHashId);
        $recommended = Product::findByHash($productRecommendedHashId);

        $product->recommendeds()->attach($recommended->id);

        return response()->json(['success' => true]);
    }

    public function removeRecommend($productParentHashId, $productRecommendedHashId)
    {
        $product = Product::findByHash($productParentHashId);
        $recommended = Product::findByHash($productRecommendedHashId);

        $product->recommendeds()->detach($recommended->id);

        return response()->json(['success' => true]);
    }

    private function formatProduct()
    {
        $product = function ($product) {
            /** @var Product $product */
            return [
                'id'      => $product->id,
                'hash_id' => $product->hash_id,
                'name'    => $product->name,
                'price'   => $product->price,
                'photos'  => $product->photos->transform(function ($photo) {
                    /** @var Photo $photo */
                    return [
                        'hash_id' => $photo->hash_id,
                        'url'     => $photo->url,
                        'order'   => $photo->order,
                    ];
                })->toArray(),
            ];
        };

        return $product;
    }
}