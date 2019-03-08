<?php

namespace App\Providers;

use App\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\File;
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

    /**
     * saveFileAsImage takes an UploadedFile (e.g. from an HTTP form)
     * and saves it as an Image, along with different qualities.
     */
    public static function saveFileAsImage(UploadedFile $file, $filename, $directory, array $options = null)
    {
        // List of qualities to save
        $qualities = isset($options['qualities']) ? $options['qualities'] : null;
        if (!$qualities) {
            $qualities = ['large', 'medium', 'small', 'share'];
        }

        // Image order 
        $image_order = isset($options['image_order']) ? (int)$options['image_order'] : 1;

        // Crop square from center?
        $crop_center = isset($options['cropFromCenter']) ? $options['cropFromCenter'] : false;

        // Image to update?
        $update_image = isset($options['update']) ? $options['update'] : null;

        // Keep share image as 16x9 (landscape) 
        $landscape_share = isset($options['landscape_share']) ? $options['landscape_share'] : null;

        // Set filename
        $ext = strtolower($file->getClientOriginalExtension());
        $filename .= ".$ext";

        // Ensure directory exists
        if (!Storage::exists("public/{$directory}")) {
            Storage::makeDirectory("public/{$directory}");
        }

        // Store the original temporarily
        $path = $file->storeAs('temp', $filename);
        $original = new Image($path);

        // Dimensions
        $dim_x = isset($options['dim_x']) ? $options['dim_x'] : $original->getWidth();
        $dim_y = isset($options['dim_y']) ? $options['dim_y'] : $original->getHeight();

        if ($crop_center) {
            $dim_x = min($dim_x, $dim_y);
            $dim_y = $dim_x;
        }

        // Ensure dimensions are large enough
        while ($dim_x < 1500 || $dim_y < 1500) {
            $dim_x *= 1.25;
            $dim_y *= 1.25;
        }

        $image_url = $original->saveAs($directory, $filename);
        $image = clone $original;
        $image->order = $image_order;

        if ($crop_center) {
            $image->cropFromCenter($dim_x);
        }

        if (in_array('large', $qualities)) {
            $large = clone $image;
            $large_url = $large->resize($dim_x/2, $dim_y/2)->saveAs($directory, 'large-'.$filename);
        }
        if (in_array('medium', $qualities)) {
            $medium = clone $image;
            $medium_url = $medium->resize($dim_x/4, $dim_y/4)->saveAs($directory, 'medium-'.$filename);
        }
        if (in_array('small', $qualities)) {
            $small = clone $image;
            $small_url = $small->resize($dim_x/8, $dim_y/8)->saveAs($directory, 'small-'.$filename);
        }
        if (in_array('share', $qualities)) {
            if ($landscape_share) {
                $share = clone $original;
                $share_url = $share->resize(1120, 630)->saveAs($directory, 'share-'.$filename);
            } else {
                $white = [255, 255, 255, 0];
                $share = clone $image;
                $share_url = $share->resize(500, 500)->padTo(1000, 520, $white)->saveAs($directory, 'share-'.$filename);
            }
        }

        // Delete local temp image
        Storage::delete('temp/'.$filename);

        // Update the given image, if necessary
        if (!is_null($update_image)) {
            // Update the given Image
            $update_image->path = $original->getPath();
            $update_image->cdn = 0;
            $image = $update_image;
        }

        $image->save();

        return $image;
    }

    public static function clone(Image $image, $filename, $directory, array $options = null)
    {
        $file = new File($image->getFullPath());

        // List of qualities to save
        $qualities = isset($options['qualities']) ? $options['qualities'] : null;
        if (!$qualities) {
            $qualities = ['large', 'medium', 'small', 'share'];
        }

        // Crop square from center?
        $crop_center = isset($options['cropFromCenter']) ? $options['cropFromCenter'] : false;

        // Dimensions
        $dim_x = isset($options['dim_x']) ? $options['dim_x'] : 2000;
        $dim_y = isset($options['dim_y']) ? $options['dim_y'] : 2000;

        $filename .= ".{$image->getExtension()}";

        // Ensure directory exists
        if (!Storage::exists("public/{$directory}")) {
            Storage::makeDirectory("public/{$directory}");
        }

        // Store the original temporarily
        $path = Storage::putFileAs('temp', $file, $filename);

        $image = new Image($path);
        if ($crop_center) {
            $image_url = $image->cropFromCenter($dim_x);
        }
        $image_url = $image->saveAs($directory, $filename);
        if (in_array('large', $qualities)) {
            $large = clone $image;
            $large_url = $large->resize($dim_x/2, $dim_y/2)->saveAs($directory, 'large-'.$filename);
        }
        if (in_array('medium', $qualities)) {
            $medium = clone $image;
            $medium_url = $medium->resize($dim_x/4, $dim_y/4)->saveAs($directory, 'medium-'.$filename);
        }
        if (in_array('small', $qualities)) {
            $small = clone $image;
            $small_url = $small->resize($dim_x/8, $dim_y/8)->saveAs($directory, 'small-'.$filename);
        }
        if (in_array('share', $qualities)) {
            $white = [255, 255, 255, 0];
            $share = clone $image;
            $share_url = $share->resize(500, 500)->padTo(1000, 520, $white)->saveAs($directory, 'share-'.$filename);
        }

        // Delete local temp image
        Storage::delete('temp/'.$filename);

        $image->save();

        return $image;
    }
}
