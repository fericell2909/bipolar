<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Video;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\UploadFileS3;

class VideoController extends Controller
{
    public function productUpload(Request $request, $productHashId)
    {
        $this->validate($request, ['file' => 'required']);

        $product = Product::findByHash($productHashId);
        $image = $request->file('file');

        if ($image->isValid()) {
            $photoService = new UploadFileS3;
            $imagePath = $photoService->uploadVideo_do_spaces($image, 'videos', $product->slug);

            $fullPath = $photoService->getDoSpacesPath($imagePath) ?? "";

            $photo = new Video;
            $photo->product()->associate($product);
            $photo->url = $fullPath;
            $photo->relative_url = $imagePath;
            $photo->order = 0;
            $photo->save();
        }

        return response()->json($fullPath);
    }


    public function orderVideos(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $photoHashId) {
            $photo = Video::findByHash($photoHashId);
            $photo->order = $orderKey;
            $photo->save();
        }

        return response()->json(['success' => true]);
    }
}
