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
use App\Models\TextCondition;
use LaravelLocalization;

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
                })->orderBy('order');
            },
            'subtypes.products' => function ($withProducts) {
                $withProducts->where('state_id', config('constants.STATE_ACTIVE_ID'));
            },
        ])
            ->has('subtypes')
            ->orderBy('order')
            ->get();

        $sizes = Size::whereHas('stocks', function ($whereStocks) {
            $whereStocks
                ->whereHas('product', function ($whereHasProduct) {
                    /** @var Builder $whereHasProduct */
                    $whereHasProduct->where('state_id', config('constants.STATE_ACTIVE_ID'));
                })
                ->whereNotNull('active')
                ->where('quantity', '>', 0);
        })
            ->with(['stocks' => function ($withStocks) {
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
                'label',
            ])
            ->when($request->filled('subtypes'), function ($whereProducts) use ($selectedSubtypes) {
                return $whereProducts->whereHas('subtypes', function ($whereSubtype) use ($selectedSubtypes) {
                    $whereSubtype->whereIn('slug', $selectedSubtypes);
                });
            })
            ->when($request->filled('sizes'), function ($whereProducts) {
                $whereProducts->has('stocks');
            })
            ->when((bool)optional(\Auth::user())->has_showroom_sale === false, function ($products) {
                /** @var Builder $products */
                $products->where('is_showroom_sale', false);
            })
            ->when($request->filled('search'), function ($products) use ($request) {
                /** @var Collection $products */
                return $products->where('name', 'like', "%{$request->input('search')}%");
            })
            ->orderBy('order')
            ->get()
            ->when($request->filled('sizes'), $this->filterBySize($selectedSizes))
            ->when($request->filled('subtypes'), $this->filterBySubtype($selectedSubtypes))
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

        /** @var \App\Models\Banner $firstBanner */
        $firstBanner = Banner::onlyImageType()->orderBy('order')->first();
        $seoHeaderUrl = optional($firstBanner)->url ?? config('constants.SEO_IMAGE_DEFAULT_URL');
        if ($request->anyFilled(['search', 'sizes', 'subtypes', 'orderBy']) && $products->count() > 0) {
            /** @var Product $seoProduct */
            $seoProduct = $products->first();
            if (!is_null(optional($seoProduct->photos->first())->url)) {
                $seoHeaderUrl = optional($seoProduct->photos->first())->url;
            }
        }
        \SEO::twitter()->addImage($seoHeaderUrl);
        \SEO::opengraph()->setType('article')->addImage($seoHeaderUrl, ['width' => 1024, 'height' => 680]);

        $products = $this->getPaginatedProducts($products, LengthAwarePaginator::resolveCurrentPage(), $request->fullUrl());

        return view('web.shop.shop', compact(
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

    /**
     * Check if products have all subtypes selected
     *
     * @param array $selectedSubtypes
     * @return \Closure
     */
    private function filterBySubtype(array $selectedSubtypes)
    {
        return function ($products) use ($selectedSubtypes) {
            /** @var Collection $products */
            return $products->filter(function ($product) use ($selectedSubtypes) {
                /** @var Product $product */
                if (count($selectedSubtypes) === 1) {
                    return $product->subtypes->whereIn('slug', $selectedSubtypes)->count() > 0;
                }

                $subtypeSlugs = $product->subtypes->pluck('slug')->toArray();

                return count(array_diff($selectedSubtypes, $subtypeSlugs)) === 0;
            });
        };
    }

    private function filterBySize(array $selectedSizes)
    {
        return function ($products) use ($selectedSizes) {
            /** @var Collection $products */
            return $products->filter(function ($product) use ($selectedSizes) {
                /** @var Product $product */
                // if product has the size and have quantity
                return $product->stocks
                        ->filter(function ($stock) use ($selectedSizes) {
                            return in_array($stock->size->slug, $selectedSizes);
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
        $fitWidths = collect([
            ['name' => __('bipolar.shop.fit_widths.very_low'), 'value' => config('constants.FIT_VERY_LOW')],
            ['name' => __('bipolar.shop.fit_widths.low'), 'value' => config('constants.FIT_LOW')],
            ['name' => __('bipolar.shop.fit_widths.normal'), 'value' => config('constants.FIT_NORMAL')],
            ['name' => __('bipolar.shop.fit_widths.high'), 'value' => config('constants.FIT_HIGH')],
            ['name' => __('bipolar.shop.fit_widths.very_high'), 'value' => config('constants.FIT_VERY_HIGH')],
        ]);
        $fitInsteps = collect([
            ['name' => __('bipolar.shop.fit_instep.very_low'), 'value' => config('constants.FIT_VERY_LOW')],
            ['name' => __('bipolar.shop.fit_instep.low'), 'value' => config('constants.FIT_LOW')],
            ['name' => __('bipolar.shop.fit_instep.normal'), 'value' => config('constants.FIT_NORMAL')],
            ['name' => __('bipolar.shop.fit_instep.high'), 'value' => config('constants.FIT_HIGH')],
            ['name' => __('bipolar.shop.fit_instep.very_high'), 'value' => config('constants.FIT_VERY_HIGH')],
        ]);

        $product->load([
            'stocks.size',
            'photos'                 => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            },
            'recommendations'        => function ($withRecommendeds) {
                return $withRecommendeds->where('state_id', config('constants.STATE_ACTIVE_ID'));
            },
            'recommendations.photos' => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            },
        ]);

        if ($this->isOutOfStock($product)) {
            $product->is_soldout = true;
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

        
        $textCondition = TextCondition::where('available',1)->first();
        
        if($textCondition){
            $textConditionDescription = urlencode($textCondition->getTranslation('description','es'));
        } else 
        {
            $textConditionDescription  = '';
        }

        return view('web.shop.product', compact(
            'product',
            'stockWithSizes',
            'quantities',
            'productIsShoeType',
            'fitWidths',
            'fitInsteps',
            'textConditionDescription'
        ));

        

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
