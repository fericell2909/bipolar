<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;

class ShopController extends Controller
{
    public function shop()
    {
        $products = Product::whereNotNull('active')
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                }
            ])
            ->paginate(12);
        $productsSalient = Product::whereNotNull('is_salient')
            ->whereNotNull('active')
            ->with([
                'photos' => function ($withPhotos) {
                    $withPhotos->orderBy('order');
                }
            ])
            ->orderBy('name')
            ->get();
        $types = Type::with(['subtypes', 'subtypes.products'])->get();

        $sizes = Size::with(['stocks' => function ($withStocks) {
            /** @var Builder $withStocks */
            $withStocks->whereHas('product', function ($whereHasProduct) {
                /** @var Builder $whereHasProduct */
                $whereHasProduct->whereNotNull('active');
            })
                ->whereNotNull('active');
        }])->orderBy('name')->get();

        $sizes = $sizes->each(function (&$size) {
            /** @var Size $size */
            $productsArray = [];

            $size->stocks->each(function ($stock) use (&$productsArray) {
                /** @var Stock $stock */
                $productsArray[] = $stock->product->id;
            });

            $size->product_count = count($productsArray);
        });

        return view('web.shop.shop', compact(
            'countProducts',
            'products',
            'types',
            'sizes',
            'productsSalient'
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