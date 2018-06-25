<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ShopFilterRequest;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Type;
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
        $productsSalient = Product::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->whereNotNull('is_salient')
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                },
                'colors',
            ])
            ->orderBy('order')
            ->get();

        $types = Type::with([
            'subtypes',
            'subtypes.products' => function ($withProducts) {
                $withProducts->where('state_id', config('constants.STATE_ACTIVE_ID'));
            },
        ])->get();

        $sizes = Size::with(['stocks' => function ($withStocks) {
            /** @var Builder $withStocks */
            $withStocks->whereHas('product', function ($whereHasProduct) {
                /** @var Builder $whereHasProduct */
                $whereHasProduct->where('state_id', config('constants.STATE_ACTIVE_ID'));
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
            'default'   => __('bipolar.shop.order_default'),
            'priceup'   => __('bipolar.shop.order_priceup'),
            'pricedown' => __('bipolar.shop.order_pricedown'),
        ];
        $selectedOrderOption = $request->filled('orderBy') ? $request->input('orderBy') : null;

        $products = Product::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                },
                'subtypes',
                'stocks',
                'stocks.size',
                'colors',
            ])
            ->orderBy('order')
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
                    case 'priceup':
                        $products = $products->sortBy('price');
                        break;
                    case 'pricedown':
                        $products = $products->sortByDesc('price');
                        break;
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

        $product->load('stocks.size');

        $stockWithSizes = $product->stocks
            ->filter(function ($stock) {
                /** @var Stock $stock */
                return !is_null($stock->size_id);
            })
            //->pluck('size.name', 'hash_id')
            ->transform(function ($stock) {
                /** @var Stock $stock */
                return [
                    'hash_id'  => $stock->hash_id,
                    'size'     => $stock->size->name,
                    'quantity' => $stock->quantity,
                    'one_left' => $stock->quantity === 1 ? true : false,
                ];
            })
            ->toArray();

        $quantities = [];
        foreach (range(1, 10) as $number) {
            $quantities[$number] = $number;
        }

        $seoDescription = !empty($product->description) ? $product->description : 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru';
        $image = optional($product->photos->first())->url;
        \SEO::metatags()->setTitle("{$product->name}")->setDescription($seoDescription);
        \SEO::twitter()
            ->setTitle("{$product->name} - Bipolar")
            ->setDescription($seoDescription)
            ->addImage($image);
        \SEO::opengraph()
            ->setType('article')
            ->setTitle("{$product->name} - Bipolar")
            ->setDescription($seoDescription)
            ->addImage($image, ['width'  => 1024, 'height' => 680]);

        return view('web.shop.product', compact('product', 'stockWithSizes', 'quantities'));
    }
}
