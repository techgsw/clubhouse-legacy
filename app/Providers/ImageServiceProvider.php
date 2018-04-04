<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\UploadedFile;

class ImageServiceProvider extends ServiceProvider
{
    public static function pushToS3()
    {
        Image::where('cdn', false)->each(function ($image) {
            // Upload to S3
        });
    }
}
