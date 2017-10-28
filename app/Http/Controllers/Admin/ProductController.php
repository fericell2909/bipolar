<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductNewRequest;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->with('colors')->get();

        return view('admin.products.products', compact('products'));
    }

    public function create()
    {
        $colors = Color::orderBy('name')->get()->pluck('name', 'hash_id');
        $types = Type::orderBy('name')->get();
        $sizes = Size::orderBy('name')->get();

        return view('admin.products.product_new', compact('colors', 'types', 'sizes'));
    }

    public function store(ProductNewRequest $request)
    {
        $colors = [];
        $subtypes = [];
        $requestColors = $request->input('colors');

        foreach ($requestColors as $color) {
            $colors[] = array_first(\Hashids::decode($color));
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->subtitle = $request->input('subtitle');
        $product->description = $request->input('description');
        $product->price = number_format($request->input('price'), 2);
        $product->active = boolval($request->input('active')) ? now() : null;
        $product->save();
        $product->colors()->sync($colors);

        if ($request->has('subtypes')) {
            $requestSubtypes = $request->input('subtypes');
            foreach ($requestSubtypes as $subtypeHashId) {
                $subtypes[] = array_first(\Hashids::decode($subtypeHashId));
            }
            $product->subtypes()->sync($subtypes);
        }

        if ($request->has('sizes')) {
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

        return redirect()->route('products.photos', $product->slug);
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
            $imagePath = $image->storePubliclyAs('products', "{$product->slug}_{$now->timestamp}.{$image->extension()}", 's3');
            $amazonPath = "https://s3.amazonaws.com/{$bucket}/{$imagePath}";

            $photo = new Photo;
            $photo->product()->associate($product);
            $photo->url = $amazonPath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json(compact('path'));
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

    public function salientAndHome()
    {
        $products = Product::orderBy('name')->get();

        $productsForSelect = $products->mapWithKeys(function ($product) {
            /** @var Product $product */
            return [$product->id => "{$product->name} - {$product->subtitle} - {$product->price}"];
        });

        $productsInSalient = $products->filter->is_salient;
        $productsInHome = $products->filter->is_home;


        return view('admin.products.salient_and_home', compact('productsForSelect', 'productsInSalient', 'productsInHome'));
    }

    public function salientAndHomeSave(Request $request)
    {
        if ($request->input('homes')) {
            Product::whereNotNull('is_home')->update(['is_home' => null]);
            Product::whereIn('id', $request->input('homes'))->update(['is_home' => date('Y-m-d H:i:s')]);
        }

        if ($request->input('salients')) {
            Product::whereNotNull('is_home')->update(['is_salient' => null]);
            Product::whereIn('id', $request->input('salients'))->update(['is_salient' => date('Y-m-d H:i:s')]);
        }

        flash()->success('Se guardó los cambios con éxito');

        return redirect()->back();
    }
}