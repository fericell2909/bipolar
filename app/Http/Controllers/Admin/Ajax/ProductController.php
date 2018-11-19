<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductNewRequest;
use App\Http\Resources\AdminStockResource;
use App\Models\Color;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Size;
use App\Models\State;
use App\Models\Stock;
use App\Models\Subtype;
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
            ->with(['photos' => function ($withPhotos) {
                $withPhotos->orderBy('order');
            }])
            ->get();

        return new ProductCollection($products);
    }

    public function recommendeds($productHashId)
    {
        $product = Product::findByHash($productHashId);
        $product->load('photos');

        $recommendeds = $product->recommendeds;
        $recommendeds->load('photos', 'state');

        return new ProductCollection($recommendeds);
    }

    public function recommend($productParentHashId, $productRecommendedHashId)
    {
        $product = Product::findByHash($productParentHashId);
        $recommended = Product::findByHash($productRecommendedHashId);

        $product->recommendeds()->syncWithoutDetaching($recommended->id);

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
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                },
                'subtypes', 
                'state',
                'stocks.size',
                'colors',
            ])
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
        $settings = Settings::first();

        $product = new Product;
        $product->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $product->setTranslations('description', [
            'es' => $request->input('description'),
            'en' => $request->input('description_english'),
        ]);
        $product->description = $request->input('description');
        $product->price = number_format($request->input('price'), 2, '.', '');
        $product->price_dolar = !is_null($settings) ? round($request->input('price') / $settings->dolar_change) : 0;
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
        $settings = Settings::first();

        $product = Product::findByHash($productHashId);
        $product->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $product->setTranslations('description', [
            'es' => $request->input('description'),
            'en' => $request->input('description_english'),
        ]);
        $product->price = number_format($request->input('price'), 2, '.', '');
        $product->price_dolar = !is_null($settings) ? round($request->input('price') / $settings->dolar_change) : 0;
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
            $currentSizes = $product->sizes_mapped()->pluck('id')->toArray();

            // Remove the unused products
            $unusedSizes = array_diff($currentSizes, $requestSizes);

            if (count($unusedSizes)) {
                $stocks = $product->stocks()->whereIn('size_id', $unusedSizes)->get();
                $stocks->each(function ($stock) {
                    $stock->delete();
                });
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
            case "draft":
                $state = State::find(config('constants.STATE_PREVIEW_ID'));
                break;
            case "pending":
                $state = State::find(config('constants.STATE_WAITING_ID'));
                break;
            case "published":
                $state = State::find(config('constants.STATE_ACTIVE_ID'));
                break;
            case "reviewed":
                $state = State::find(config('constants.STATE_REVIEW_ID'));
                break;
            default:
                $state = State::first();
                break;
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

    public function orderProductsAndSave(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $photoHashId) {
            $photo = Product::findByHash($photoHashId);
            $photo->order = $orderKey;
            $photo->save();
        }

        return response()->json(['success' => true]);
    }

    public function stocks($productHashId)
    {
        $product = Product::findByHash($productHashId);

        return AdminStockResource::collection($product->stocks);
    }

    public function updateStock(Request $request, $stockId)
    {
        $this->validate($request, [
            'bsaleStockId' => 'required',
            'quantity'     => 'required',
        ]);

        /** @var Stock $productStock */
        $productStock = Stock::findOrFail($stockId);
        $productStock->bsale_stock_id = $request->input('bsaleStockId');
        $productStock->quantity = $request->input('quantity');
        $productStock->save();

        return new AdminStockResource($productStock);
    }

    public function updateDiscount(Request $request, $productHashId)
    {
        $this->validate($request, [
            'discount_pen'         => 'required|numeric',
            'discount_usd'         => 'required|numeric',
            'price_usd_discount'   => 'required|numeric',
            'price_pen_discount' => 'required|numeric',
        ]);

        $product = Product::findByHash($productHashId);
        $product->discount_pen = intval($request->input('discount_pen')) === 0 ? null : $request->input('discount_pen');
        $product->discount_usd = intval($request->input('discount_usd')) === 0 ? null : $request->input('discount_usd');
        $product->price_pen_discount = intval($request->input('price_pen_discount')) === 0 ? null : $request->input('price_pen_discount');
        $product->price_usd_discount = intval($request->input('price_usd_discount')) === 0 ? null : $request->input('price_usd_discount');
        $product->save();

        return response()->json(['mensaje' => 'Guardado con éxito']);
    }
}
