<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;

class UploadFileS3
{
    public function uploadPhoto(UploadedFile $image, string $folder, string $imageName): string
    {
        $now = now();
        $fullNameImage = "{$imageName}_{$now->timestamp}.{$image->extension()}";

        return $image->storePubliclyAs($folder, $fullNameImage, [
            'CacheControl' => 'max-age=31536000',
            'disk'         => 's3',
        ]);
    }

    public function getAmazonPath($imageRelativePath)
    {
        $bucket = env('AWS_BUCKET');

        return "https://s3.amazonaws.com/{$bucket}/{$imageRelativePath}";
    }
}