<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountTask;
use App\Models\FitSize;
use App\Models\FitWidth;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Stock;

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

        if (\Storage::disk('public')->exists($photo->relative_url)) {
            \Storage::disk('public')->delete($photo->relative_url);
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

    public function sizeCalculation(string $productSlug)
    {
        $product = Product::findBySlugOrFail($productSlug);
        $fitsSizes = FitSize::all();
        $fitsWidths = FitWidth::all();

        return view('admin.products.calculate_size', compact('product', 'fitsSizes', 'fitsWidths'));
    }

    public function sizeCalculationStore(string $productSlug)
    {
        /** @var Product $product */
        $product = Product::findBySlugOrFail($productSlug);
        $fitSize = FitSize::whereUuid(request()->input('fit_size'))->first();
        $fitWidth = FitWidth::whereUuid(request()->input('fit_width'))->first();

        $product->fit_size_id = $fitSize->id;
        $product->fit_width_id = $fitWidth->id;
        $product->width_level_very_low = request()->input('width_very_low');
        $product->width_level_low = request()->input('width_low');
        $product->width_level_normal = request()->input('width_normal');
        $product->width_level_high = request()->input('width_high');
        $product->width_level_very_high = request()->input('width_very_high');
        $product->instep_level_very_low = request()->input('instep_very_low');
        $product->instep_level_low = request()->input('instep_low');
        $product->instep_level_normal = request()->input('instep_normal');
        $product->instep_level_high = request()->input('instep_high');
        $product->instep_level_very_high = request()->input('instep_very_high');
        $product->save();

        return back();
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->orderByDesc('id')->with(['state', 'colors'])->paginate(20);

        return view('admin.products.trashed', compact('products'));
    }

    public function deletehard($productHashId)
    {
        $product = Product::findByHashTrashed($productHashId);

        $product->recommendations()->detach();
        $product->recommended_by()->detach();
        $product->subtypes()->detach();
        $product->stocks->each(function ($stock) {
            /** @var Stock $stock */
            $stock->buy_details()->delete();
            $stock->delete();
        });
        $product->photos->each(function ($photo) {
            /** @var Photo $photo */
            if (\Storage::disk('public')->exists($photo->relative_url)) {
                \Storage::disk('public')->delete($photo->relative_url);
            }
            $photo->delete();
        });

        $product->forceDelete();

        flash()->success("Se eliminaron todos los datos del producto correctamente");

        return redirect()->back();
    }

    public function restore($productHashId)
    {
        $product = Product::findByHashTrashed($productHashId);
        $product->restore();

        flash()->success("Produto {$product->name} (ID: #{$product->id}) restaurado");

        return back();
    }

    public function order()
    {
        $products = Product::orderBy('order')
            ->orderByDesc('id')
            ->with('photos', 'state', 'colors')
            ->get();

        return view('admin.products.products_order', compact('products'));
    }

    public function preview($productSlug)
    {
        /** @var Product $product */
        $product = Product::findBySlugOrFail($productSlug);

        $product->load(['stocks.size', 'photos' => function ($withPhotos) {
            return $withPhotos->orderBy('order');
        }, 'recommendations.photos' => function ($withPhotos) {
            return $withPhotos->orderBy('order');
        }]);

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

        $productIsShoeType = false;
        if ($product->subtypes->count()) {
            $productIsShoeType = in_array(config('constants.TYPES.SHOES'), $product->subtypes->pluck('type_id')->toArray());
        }

        return view('web.shop.product', compact('product', 'stockWithSizes', 'quantities', 'productIsShoeType'));
    }

    public function stock($productSlug)
    {
        $product = Product::findBySlugOrFail($productSlug);

        return view('admin.products.stocks', compact('product'));
    }

    public function discount($productSlug)
    {
        $product = Product::findBySlugOrFail($productSlug);

        return view('admin.products.discount', compact('product'));
    }

    public function multipleDiscountEdit($discountHashId)
    {
        $discount = DiscountTask::findByHash($discountHashId);

        return view('admin.products.multiple_discounts_edit', compact('discount'));
    }

    public function massive()
    {
        return view('admin.products.massive_publication');
    }
}
