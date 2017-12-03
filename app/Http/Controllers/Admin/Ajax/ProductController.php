<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductNewRequest;
use App\Models\{
    Color, Photo, Product, Size, Stock, Subtype
};
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            }, 'subtypes'])
            ->get();

        return response()->json(new ProductCollection($products));
    }

    public function store(ProductNewRequest $request)
    {
        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = number_format($request->input('price'), 2);
        $product->is_salient = boolval($request->input('salient')) ? now() : null;
        $product->save();

        if ($request->filled('colors')) {
            $requestColors = $request->input('colors');
            $colors = Color::findByManyHash($requestColors)->pluck('id')->toArray();
            $product->colors()->sync($colors);
        }

        if ($request->filled('subtypes')) {
            $requestSubtypes = $request->input('subtypes');
            $subtypes = Subtype::findByManyHash($requestSubtypes)->pluck('id')->toArray();
            $product->subtypes()->sync($subtypes);
        }

        if ($request->filled('sizes')) {
            $requestSizes = $request->input('sizes');
            foreach ($requestSizes as $sizeHashId) {
                $size = Size::findByHash($sizeHashId);
                $stock = new Stock;
                $stock->product()->associate($product);
                $stock->size()->associate($size);
                $stock->incoming_date = now()->toDateString();
                $stock->active = now();
                $stock->save();
            }
        }

        return response()->json(new ProductResource($product), Response::HTTP_CREATED);
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

    public function deletehard($productHashId)
    {
        $product = Product::findByHash($productHashId);

        $product->recommendeds()->sync([]);
        $product->subtypes()->sync([]);
        $product->stocks->each(function ($stock) {
            /** @var Stock $stock */
            $stock->delete();
        });
        $product->photos->each(function ($photo) {
            /** @var Photo $photo */
            if (\Storage::disk('s3')->exists($photo->relative_url)) {
                \Storage::disk('s3')->delete($photo->relative_url);
            }
            $photo->delete();
        });
        $product->delete();

        return response()->json(['success' => true]);
    }

    public function deletesoft($productHashId)
    {
        $product = Product::findByHash($productHashId);
        
        $product->delete();

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