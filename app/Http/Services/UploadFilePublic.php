<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;

class UploadFilePublic
{
    public function uploadPhoto(UploadedFile $image, string $folder, string $imageName): string
    {
        $now = now();
        $randomString = str_random(3);
        $fullNameImage = "{$imageName}_{$now->timestamp}_{$randomString}.{$image->extension()}";

        return \Storage::disk('public')->putFileAs("bipolar-images/$folder", $image, $fullNameImage);
    }

    public function getFullUrl(string $imagePath)
    {
        return \Storage::disk('public')->url($imagePath);
    }
}