<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadFileS3
{
    public function uploadPhoto(UploadedFile $image, string $folder, string $imageName): string
    {
        $now = now();
        $randomString = Str::random(3);
        $fullNameImage = "{$imageName}_{$now->timestamp}_{$randomString}.{$image->extension()}";

        return $image->storePubliclyAs($folder, $fullNameImage, [
            'CacheControl' => 'max-age=31536000',
            'disk'         => 's3',
        ]);
    }

    public function getAmazonPath($imageRelativePath)
    {
        $bucket = config('app.aws_bucket');

        return "https://s3.amazonaws.com/{$bucket}/{$imageRelativePath}";
    }
}
