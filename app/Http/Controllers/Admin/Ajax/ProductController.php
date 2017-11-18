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

    public function get(Request $request)
    {
        $products = Product::orderByDesc('id')
            ->with(['photos' => function ($withPhotos) {
                $withPhotos->orderBy('order');
            }])
            ->get()
            ->when($request->filled('active'), function ($products) use ($request) {
                $active = boolval($request->input('active'));

                return $products->filter(function ($product) use ($active) {
                    return boolval($product->active) === $active;
                });
            })
            ->transform($this->formatProduct())
            ->values()
            ->all();

        return response()->json($products);
    }

    public function update(Request $request, $productHashId)
    {
        $this->validate($request, ['update' => 'sometimes|boolean']);

        $product = Product::findByHash($productHashId);

        if ($request->filled('active')) {
            $product->active = boolval($request->input('active')) === true ? now() : null;
        }

        $product->save();

        return response()->json($product);
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
                'active'  => $product->active,
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