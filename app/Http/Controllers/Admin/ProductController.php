<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Photo, Product, Stock
};

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.products');
    }

    public function create()
    {
        return view('admin.products.product_new');
    }

    public function photos($productSlug)
    {
        $product = Product::findBySlugOrFail($productSlug);

        return view('admin.products.photos', compact('product'));
    }

    public function deletePhoto($photoHashId)
    {
        $photo = Photo::findByHash($photoHashId);

        if (\Storage::disk('s3')->exists($photo->relative_url)) {
            \Storage::disk('s3')->delete($photo->relative_url);
        }

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto eliminada correctamente',
        ]);
    }

    public function seePhotos($productSlug)
    {
        $product = Product::findBySlug($productSlug);

        $product->load(['photos' => function ($queryWithPhotos) {
            return $queryWithPhotos->orderBy('order');
        }]);

        return view('admin.products.photos_order', compact('product'));
    }

    public function edit($productHashId)
    {
        $product = Product::findByHash($productHashId);

        return view('admin.products.product_edit', compact('product'));
    }

    public function recommended($productoId)
    {
        /** @var Product $product */
        $product = Product::findBySlug($productoId);

        return view('admin.products.recommended', compact('product'));
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->get();

        return view('admin.products.trashed', compact('products'));
    }

    public function deletehard($productHashId)
    {
        $product = Product::findByHashTrashed($productHashId);

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

        $product->forceDelete();

        flash()->success("Se eliminaron todos los datos del producto correctamente");

        return redirect()->back();
    }

    public function order()
    {
        $products = Product::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->orderBy('order')
            ->with('photos')
            ->get();

        return view('admin.products.products_order', compact('products'));
    }

    public function preview($productSlug)
    {
        /** @var Product $product */
        $product = Product::findBySlugOrFail($productSlug);

        $product->load('stocks');

        $stockWithSizes = $product->stocks
            ->filter(function ($stock) {
                /** @var Stock $stock */
                return !is_null($stock->size_id);
            })
            ->pluck('size.name', 'hash_id')
            ->toArray();

        return view('web.shop.preview', compact('product', 'stockWithSizes'));
    }
}