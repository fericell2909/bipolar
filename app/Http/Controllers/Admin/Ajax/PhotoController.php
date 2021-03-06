<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\HomePost;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UploadFilePublic;

class PhotoController extends Controller
{
    public function homePostUpload(Request $request, $homePostHashId)
    {
        $this->validate($request, ['file' => 'required|image']);

        $homePost = HomePost::findByHash($homePostHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($image, 'homeposts', $homePost->slug);
            $fullPath = $photoService->getFullUrl($imagePath) ?? "";

            $photo = new Photo;
            $photo->home_post()->associate($homePost);
            $photo->url = $fullPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json($fullPath);
    }

    public function productUpload(Request $request, $productHashId)
    {
        $this->validate($request, ['file' => 'required|image']);

        $product = Product::findByHash($productHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($image, 'products', $product->slug);
            $fullPath = $photoService->getFullUrl($imagePath) ?? "";

            $photo = new Photo;
            $photo->product()->associate($product);
            $photo->url = $fullPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json($fullPath);
    }

    public function postUpload(Request $request, $postHashId)
    {
        $this->validate($request, ['file' => 'required|image']);

        $post = Post::findByHash($postHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($image, 'posts', $post->slug);
            $fullPath = $photoService->getFullUrl($imagePath) ?? "";

            $photo = new Photo;
            $photo->url = $fullPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->post()->associate($post);
            $photo->save();
        }

        return response()->json($fullPath);
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
}
