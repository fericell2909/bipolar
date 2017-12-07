<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductNewRequest;
use App\Models\{
    Color, Photo, Product, Settings, Size, State, Stock, Subtype
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
            }, 'subtypes', 'state', 'stocks.size'])
            ->get();

        return response()->json(new ProductCollection($products));
    }

    public function show($productHashId)
    {
        $product = Product::findByHash($productHashId);

        $product->load('state', 'colors', 'subtypes', 'stocks');

        return new ProductResource($product);
    }

    public function store(ProductNewRequest $request)
    {
        $state = State::findByHash($request->input('state'));

        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = number_format($request->input('price'), 2, '.', '');
        $product->weight = $request->filled('weight') ? $request->input('weight') : null;
        $product->free_shipping = boolval($request->input('free_shipping'));
        $product->is_salient = boolval($request->input('salient')) ? now() : null;
        $product->state()->associate($state);
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

    public function update(ProductNewRequest $request, $productHashId)
    {
        $state = State::findByHash($request->input('state'));

        $product = Product::findByHash($productHashId);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = number_format($request->input('price'), 2, '.', '');
        $product->weight = $request->filled('weight') ? $request->input('weight') : null;
        $product->free_shipping = boolval($request->input('free_shipping'));
        $product->is_salient = boolval($request->input('salient')) ? now() : null;
        $product->state()->associate($state);
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
            $requestSizes = Size::findByManyHash($request->input('sizes'))->pluck('id')->toArray();
            $currentSizes = $product->sizes()->pluck('id')->toArray();

            // Remove the unused products
            $unusedSizes = array_diff($currentSizes, $requestSizes);

            if (count($unusedSizes)) {
                $stocks = $product->stocks()->whereIn('size_id', $unusedSizes)->get();
                $stocks->each(function ($stock) { $stock->delete(); });
            }

            // Add new products
            $newSizes = array_diff($requestSizes, $currentSizes);

            foreach ($newSizes as $sizeId) {
                $size = Size::find($sizeId);
                $stock = new Stock;
                $stock->product()->associate($product);
                $stock->size()->associate($size);
                $stock->incoming_date = now()->toDateString();
                $stock->active = now();
                $stock->save();
            }
        }

        return response()->json(new ProductResource($product));
    }

    public function deletesoft($productHashId)
    {
        $product = Product::findByHash($productHashId);
        
        $product->delete();

        return response()->json(['success' => true]);
    }

    public function freeShippingToggle(Request $request, $activate)
    {
        $this->validate($request, ['products' => 'required|array']);

        $activate = boolval($activate);
        $products = Product::findByManyHash($request->input('products'));

        $products->each(function ($product) use ($activate) {
            /** @var Product $product */
            $product->free_shipping = $activate;
            $product->save();
        });

        return response()->json(['message' => 'Hecho']);
    }

    public function salientToggle(Request $request, $activate)
    {
        $this->validate($request, ['products' => 'required|array']);

        $activate = boolval($activate);
        $products = Product::findByManyHash($request->input('products'));

        $products->each(function ($product) use ($activate) {
            /** @var Product $product */
            $product->is_salient = ($activate ? now() : null);
            $product->save();
        });

        return response()->json(['message' => 'Hecho']);
    }

    public function stateToggle(Request $request, $stateOption)
    {
        $this->validate($request, ['products' => 'required|array']);

        $products = Product::findByManyHash($request->input('products'));

        switch ($stateOption) {
            case "draft": $state = State::find(1); break;
            case "pending": $state = State::find(2); break;
            case "published": $state = State::find(3); break;
            default: $state = State::first(); break;
        }

        $products->each(function ($product) use ($state) {
            /** @var Product $product */
            $product->state()->associate($state);
            $product->save();
        });

        return response()->json(['message' => 'Hecho']);
    }

    public function changeDolarPrice(Request $request)
    {
        $this->validate($request, ['products' => 'required|array']);

        $products = Product::findByManyHash($request->input('products'));
        /** @var Settings $settings */
        $settings = Settings::first();

        $dolarPrice = $settings->dolar_change === 0 ? 1 : $settings->dolar_change;

        $products->each(function ($product) use ($dolarPrice) {
            /** @var Product $product */
            $product->price_dolar = round($product->price / $dolarPrice);
            $product->save();
        });

        return response()->json(['message' => 'Hecho']);
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