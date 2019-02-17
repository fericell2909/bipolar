<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ShopFilterRequest;
use App\Models\Banner;
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
        $selectedSubtypes = $request->input('subtypes', []);
        $selectedSizes = $request->input('sizes', []);

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
            'subtypes'          => function ($withSubtypes) {
                $withSubtypes->whereHas('products', function ($whereProducts) {
                    $whereProducts->where('state_id', config('constants.STATE_ACTIVE_ID'));
                })->orderByDesc('updated_at');
            },
            'subtypes.products' => function ($withProducts) {
                $withProducts->where('state_id', config('constants.STATE_ACTIVE_ID'));
            },
        ])
            ->has('subtypes')
            ->orderBy('order')
            ->get();

        $sizes = Size::with(['stocks' => function ($withStocks) {
            /** @var Builder $withStocks */
            $withStocks
                ->whereHas('product', function ($whereHasProduct) {
                    /** @var Builder $whereHasProduct */
                    $whereHasProduct->where('state_id', config('constants.STATE_ACTIVE_ID'));
                })
                ->whereNotNull('active')
                ->where('quantity', '>', 0);
        }, 'stocks.product'])
            ->orderBy('name')
            ->get();

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
            ->when($request->filled('subtypes'), function ($whereProducts) {
                $whereProducts->has('subtypes');
            })
            ->when($request->filled('sizes'), function ($whereProducts) {
                $whereProducts->has('stocks');
            })
            ->when($request->filled('search'), function ($products) use ($request) {
                /** @var Collection $products */
                return $products->where('name', 'like', "%{$request->input('search')}%");
            })
            ->orderBy('order')
            ->get()
            ->when($request->filled('sizes'), $this->filterBySize($request))
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
                        $products = $products->sortBy($this->sortProductByPrice());
                        break;
                    case 'pricedown':
                        $products = $products->sortByDesc($this->sortProductByPrice());
                        break;
                }

                return $products;
            });

        if ($request->anyFilled(['search', 'sizes', 'subtypes', 'orderBy']) && $products->count() > 0) {
            /** @var Product $seoProduct */
            $seoProduct = $products->first();
            $selectedSubtypes = $request->input('subtypes', []);
            $selectedSizes = $request->input('sizes', []);
            \SEO::twitter()->addImage(optional($seoProduct->photos->first())->url ?? config('constants.SEO_IMAGE_DEFAULT_URL'));
            \SEO::opengraph()->setType('article')->addImage(optional($seoProduct->photos->first())->url ?? config('constants.SEO_IMAGE_DEFAULT_URL'), ['width'  => 1024,
                                                                                                                                                       'height' => 680]);
        } else {
            /** @var \App\Models\Banner $firstBanner */
            $firstBanner = Banner::orderBy('order')->first();
            if ($firstBanner->url) {
                \SEO::twitter()->addImage($firstBanner->url);
                \SEO::opengraph()->setType('article')->addImage($firstBanner->url, ['width' => 1024, 'height' => 680]);
            } else {
                \SEO::twitter()->addImage(config('constants.SEO_IMAGE_DEFAULT_URL'));
                \SEO::opengraph()->setType('article')->addImage(config('constants.SEO_IMAGE_DEFAULT_URL'), ['width'  => 1024,
                                                                                                            'height' => 680]);
            }
        }

        $products = $this->getPaginatedProducts($products, LengthAwarePaginator::resolveCurrentPage(), $request->fullUrl());

        return view('web.shop.shop', compact(
            'countProducts',
            'products',
            'types',
            'sizes',
            'productsSalient',
            'orderOptions',
            'selectedOrderOption',
            'selectedSubtypes',
            'selectedSizes'
        ));
    }

    private function filterBySize(ShopFilterRequest $request)
    {
        return function ($products) use ($request) {
            /** @var Collection $products */
            return $products->filter(function ($product) use ($request) {
                /** @var Product $product */
                // if product has the size and have quantity
                return $product->stocks
                        ->filter(function ($stock) use ($request) {
                            return in_array($stock->size->slug, $request->input('sizes'));
                        })
                        ->filter(function ($stock) {
                            return $stock->quantity > 0;
                        })
                        ->count() > 0;
            });
        };
    }

    private function sortProductByPrice()
    {
        return function ($product) {
            /** @var Product $product */
            if (\Session::get('BIPOLAR_CURRENCY', 'USD') === "USD") {
                return $product->price_usd_discount ?? $product->price_dolar;
            }

            return $product->price_pen_discount ?? $product->price;
        };
    }

    private function isOutOfStock(Product $product)
    {
        if ($product->stocks->count() === 0) {
            return false;
        }

        $emptyStocks = $product->stocks->filter(function ($stock) {
            return (int)$stock->quantity === 0;
        })->count();

        return $product->stocks->count() === $emptyStocks;
    }

    public function product($slugProduct)
    {
        /** @var Product $product */
        $product = Product::findBySlugOrFail($slugProduct);

        abort_if($product->state_id !== config('constants.STATE_ACTIVE_ID'), 404);

        $product->load([
            'stocks.size',
            'photos'              => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            },
            'recommendeds'        => function ($withRecommendeds) {
                return $withRecommendeds->where('state_id', config('constants.STATE_ACTIVE_ID'));
            },
            'recommendeds.photos' => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            },
        ]);

        if ($this->isOutOfStock($product)) {
            $product->state_id = config('constants.STATE_REVIEW_ID');
            $product->save();
        }

        $stockWithSizes = $product->stocks
            ->filter(function ($stock) {
                /** @var Stock $stock */
                return !is_null($stock->size_id);
            })
            ->sortBy('size.name')
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
        foreach (range(1, 5) as $number) {
            $quantities[$number] = $number;
        }

        $productIsShoeType = false;
        if ($product->subtypes->count()) {
            $productIsShoeType = in_array(config('constants.TYPES.SHOES'), $product->subtypes->pluck('type_id')->toArray());
        }

        $seoDescription = !empty($product->description) ? strip_tags($product->description) : 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru';
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
            ->addImage($image, ['width' => 1024, 'height' => 680]);

        return view('web.shop.product', compact('product', 'stockWithSizes', 'quantities', 'productIsShoeType'));
    }

    private function productHasStock($product)
    {
        return function ($product) {
            /** @var Product $product */
            return $product->stocks
                    ->filter(function ($stock) {
                        return $stock->quantity > 0;
                    })
                    ->count() > 0;
        };
    }
}
