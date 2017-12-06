<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductNewRequest;
use App\Models\{
    Color, Photo, Product, Size, Stock, Type
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.products', compact('products'));
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

    public function uploadPhoto(Request $request, $productHashId)
    {
        $this->validate($request, ['file' => 'required|image']);

        $product = Product::findByHash($productHashId);
        $image = $request->file('file');
        $now = Carbon::now();
        $bucket = env('AWS_BUCKET');

        if ($image->isValid()) {
            $imagePath = $image->storePubliclyAs('products', "{$product->slug}_{$now->timestamp}.{$image->extension()}", ['CacheControl' => 'max-age=31536000', 'disk' => 's3']);
            $amazonPath = "https://s3.amazonaws.com/{$bucket}/{$imagePath}";

            $photo = new Photo;
            $photo->product()->associate($product);
            $photo->url = $amazonPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json(compact('path'));
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

    public function orderAndSavePosition(Request $request)
    {
        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $photoHashId) {
            $photo = Photo::findByHash($photoHashId);
            $photo->order = $orderKey;
            $photo->save();
        }

        return response()->json(['success' => true]);
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

    public function activations()
    {
        return view('admin.products.activations');
    }
}