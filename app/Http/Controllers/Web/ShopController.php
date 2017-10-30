<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ShopFilterRequest;
use App\Models\{
    Product, Size, Stock, Type
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ShopController extends Controller
{
    private function getPaginatedProducts(Collection $products, int $currentPage, string $currentUrl)
    {
        $perPage = 12;
        $currentPageSearchResults = $products->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginator = new LengthAwarePaginator($currentPageSearchResults, $products->count(), $perPage);
        $paginator->setPath($currentUrl);

        return $paginator;
    }

    public function shop(ShopFilterRequest $request)
    {
        \Debugbar::info($request->all());

        $productsSalient = Product::whereNotNull('is_salient')
            ->whereNotNull('active')
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                }
            ])
            ->orderBy('name')
            ->get();

        $types = Type::with([
            'subtypes',
            'subtypes.products' => function ($withProducts) {
                $withProducts->whereNotNull('active');
            }
        ])->get();

        $sizes = Size::with(['stocks' => function ($withStocks) {
            /** @var Builder $withStocks */
            $withStocks->whereHas('product', function ($whereHasProduct) {
                /** @var Builder $whereHasProduct */
                $whereHasProduct->whereNotNull('active');
            })
                ->whereNotNull('active');
        }, 'stocks.product'])
            ->orderBy('name')
            ->get();

        $sizes = $sizes->each(function (&$size) {
            /** @var Size $size */
            $productsArray = [];

            $size->stocks->each(function ($stock) use (&$productsArray) {
                /** @var Stock $stock */
                $productsArray[] = $stock->product->id;
            });

            $size->product_count = count($productsArray);
        });

        $orderOptions = [
            'default'   => 'Orden predeterminado',
            'priceup'   => 'Ordenar de precio bajo a precio alto',
            'pricedown' => 'Ordenar de precio alto a precio bajo',
        ];
        $selectedOrderOption = $request->filled('orderBy') ? $request->input('orderBy') : null;

        $products = Product::whereNotNull('active')
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                },
                'subtypes',
                'stocks',
                'stocks.size',
            ])
            ->get()
            ->when($request->filled('search'), function ($products) use ($request) {
                /** @var Collection $products */
                return $products->where('name', '=', $request->input('search'));
            })
            ->when($request->filled('sizes'), function ($products) use ($request) {
                /** @var Collection $products */
                return $products->filter(function ($product) use ($request) {
                    /** @var Product $product */
                    return $product->stocks->whereIn('size.slug', $request->input('sizes'))->count() > 0;
                });
            })
            ->when($request->filled('subtypes'), function ($products) use ($request) {
                /** @var Collection $products */
                return $products->filter(function ($product) use ($request) {
                    /** @var Product $product */
                    return $product->subtypes->whereIn('slug', $request->input('subtypes'))->count() > 0;
                });
            })
            ->when($request->filled('orderBy'), function ($products) use ($request) {
                /** @var Collection $products */
                switch ($request->input('orderBy')) {
                    case 'priceup'; $products = $products->sortBy('price'); break;
                    case 'pricedown'; $products = $products->sortByDesc('price'); break;
                }

                return $products;
            });

        $products = $this->getPaginatedProducts($products, LengthAwarePaginator::resolveCurrentPage(), $request->fullUrl());

        return view('web.shop.shop', compact(
            'countProducts',
            'products',
            'types',
            'sizes',
            'productsSalient',
            'orderOptions',
            'selectedOrderOption'
        ));
    }

    public function product($slugProduct)
    {
        /** @var Product $product */
        $product = Product::findBySlugOrFail($slugProduct);

        $product->load('stocks');

        $stockWithSizes = $product->stocks
            ->filter(function ($stock) {
                /** @var Stock $stock */
                return !is_null($stock->size_id);
            })
            ->pluck('size.name', 'hash_id')
            ->toArray();

        return view('web.shop.product', compact('product', 'stockWithSizes'));
    }
}