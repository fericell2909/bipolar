<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\HomePost;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class PhotoController extends Controller
{
    public function homePostUpload(Request $request, $homePostHashId)
    {
        $this->validate($request, ['file' => 'required|image']);

        $homePost = HomePost::findByHash($homePostHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            $imagePath = $this->uploadPhoto($image, 'homeposts', $homePost->slug);
            $amazonPath = $this->getAmazonPath($imagePath) ?? "";

            $photo = new Photo;
            $photo->home_post()->associate($homePost);
            $photo->url = $amazonPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json(compact('amazonPath'));
    }

    public function productUpload(Request $request, $productHashId)
    {
        $this->validate($request, ['file' => 'required|image']);

        $product = Product::findByHash($productHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            $imagePath = $this->uploadPhoto($image, 'products', $product->slug);
            $amazonPath = $this->getAmazonPath($imagePath) ?? "";

            $photo = new Photo;
            $photo->product()->associate($product);
            $photo->url = $amazonPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json(compact('path'));
    }

    public function orderPhotos(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $photoHashId) {
            $photo = Photo::findByHash($photoHashId);
            $photo->order = $orderKey;
            $photo->save();
        }

        return response()->json(['success' => true]);
    }

    private function uploadPhoto(UploadedFile $image, string $folder, string $imageName): string
    {
        $now = now();
        $fullNameImage = "{$imageName}_{$now->timestamp}.{$image->extension()}";

        return $image->storePubliclyAs($folder, $fullNameImage, [
            'CacheControl' => 'max-age=31536000',
            'disk'         => 's3',
        ]);
    }

    private function getAmazonPath($imageRelativePath)
    {
        $bucket = env('AWS_BUCKET');

        return "https://s3.amazonaws.com/{$bucket}/{$imageRelativePath}";
    }
}
