<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\UploadedFile;

class ImageServiceProvider extends ServiceProvider
{
    public static function pushToS3($images=null, $cb=null)
    {
        if (is_null($images)) {
            $images = Image::where('cdn', false);
        }

        $images->each(function ($image) use ($cb) {
            // Upload each quality of image to S3
            try {
                $image->pushToS3();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return;
            }

            // Trigger callback, if set
            if ($cb && is_callable($cb)) {
                $cb($image);
            }
        });
    }
}
