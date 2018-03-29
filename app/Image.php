<?php

namespace App;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Image
{
    private $dimensions;
    private $path;
    private $format;
    private $resource;

    public function __construct($path)
    {
        if (!function_exists("gd_info")) {
            throw new \Exception("GD Library is required.");
        }

        $this->dimensions = array();
        $this->path = storage_path('app/public/'.$path);

        // File must exist
        if (!file_exists($this->path)) {
            throw new \Exception("File ".$this->path." does not exist");
        }

        // File must be readable
        if (!is_readable($this->path)) {
            throw new \Exception("File ".$this->path." is not readable");
        }

        // Determine format
        if (stristr(strtolower($this->path),'.gif')) {
            $this->format = 'GIF';
        } elseif (stristr(strtolower($this->path),'.jpg') || stristr(strtolower($this->path),'.jpeg')) {
            $this->format = 'JPG';
        } elseif (stristr(strtolower($this->path),'.png')) {
            $this->format = 'PNG';
        } else {
            throw new \Exception("Image: unknown file format. Must be GIF, JPEG, or PNG.");
        }

        // initialize resources if no errors
        switch ($this->format) {
            case 'GIF':
                $this->resource = imagecreatefromgif($this->path);
                break;
            case 'JPG':
                $this->resource = imagecreatefromjpeg($this->path);
                break;
            case 'PNG':
                $this->resource = imagecreatefrompng($this->path);
                break;
        }

        $size = getimagesize($this->path);
        $this->dimensions = [
            'width' => $size[0],
            'height' => $size[1]
        ];
    }

    public function __destruct()
    {
        if (is_resource($this->resource)) {
            imagedestroy($this->resource);
        }
    }

    public function getWidth()
    {
        return $this->dimensions['width'];
    }

    public function getHeight()
    {
        return $this->dimensions['height'];
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function saveAs($dir, $name)
    {
        $dir = trim($dir, "/");
        $path = storage_path('app/public/'.$dir.'/'.$name);
        switch($this->format) {
            case 'GIF':
                imagegif($this->resource, $path);
                break;
            case 'JPG':
                imagejpeg($this->resource, $path);
                break;
            case 'PNG':
                imagepng($this->resource, $path);
                break;
        }

        Storage::disk('s3')->putFileAs($dir, new File($path), $name);

        return $dir.'/'.$name;
    }

    public function crop($startX, $startY, $width, $height)
    {
        // make sure the cropped area is not greater than the size of the image
        if ($width > $this->dimensions['width']) {
            $width = $this->dimensions['width'];
        }
        if ($height > $this->dimensions['height']) {
            $height = $this->dimensions['height'];
        }
        // make sure to not starting outside the image
        if (($startX + $width) > $this->dimensions['width']) {
            $startX = ($this->dimensions['width'] - $width);
        }
        if (($startY + $height) > $this->dimensions['height']) {
            $startY = ($this->dimensions['height'] - $height);
        }
        if ($startX < 0) {
            $startX = 0;
        }
        if ($startY < 0) {
            $startY = 0;
        }

        if (function_exists("imagecreatetruecolor")) {
            $resource = imagecreatetruecolor($width, $height);
        } else {
            $resource = imagecreate($width, $height);
        }

        imagecopyresampled(
            $resource,
            $this->resource,
            0,
            0,
            $startX,
            $startY,
            $width,
            $height,
            $width,
            $height
        );

        $this->resource = $resource;
        $this->dimensions['width'] = $width;
        $this->dimensions['height'] = $height;

        return $this;
    }

    public function cropFromCenter($cropSize)
    {
        if ($cropSize > $this->dimensions['width']) {
            $cropSize = $this->dimensions['width'];
        }

        if ($cropSize > $this->dimensions['height']) {
            $cropSize = $this->dimensions['height'];
        }

        $cropX = intval(($this->dimensions['width'] - $cropSize) / 2);
        $cropY = intval(($this->dimensions['height'] - $cropSize) / 2);

        if (function_exists("imagecreatetruecolor")) {
            $resource = imagecreatetruecolor($cropSize,$cropSize);
        } else {
            $resource = imagecreate($cropSize,$cropSize);
        }

        // http://php.net/manual/en/function.imagecopyresampled.php
        // takes a rectangular area from src_image of width src_w and height
        // src_h at position (src_x,src_y) and place it in a rectangular area of
        // dst_image of width dst_w and height dst_h at position (dst_x,dst_y)
        imagecopyresampled(
            $resource,          // destination
            $this->resource,    // source
            0,                  // destination X
            0,                  // destination Y
            $cropX,             // source X (top-left)
            $cropY,             // source Y (top-left)
            $cropSize,          // destination width
            $cropSize,          // destination height
            $cropSize,          // source width
            $cropSize           // source height
        );

        $this->resource = $resource;
        $this->dimensions['width'] = $cropSize;
        $this->dimensions['height'] = $cropSize;

        return $this;
    }

    public function padTo($width, $height, array $color=null)
    {
        $width = $width ?: $this->getWidth();
        $height = $height ?: $this->getHeight();
        if ($width == $this->getWidth() && $height == $this->getHeight()) {
            return $this;
        }

        // dump("PAD {$this->getWidth()}x{$this->getHeight()} to {$width}x{$height}");

        if ($width < $this->getWidth()) {
            throw new \Exception("Image.padTo given width must exceed or equal current width");
        }

        if ($height < $this->getHeight()) {
            throw new \Exception("Image.padTo given height must exceed or equal current height");
        }

        if (is_null($color) || count($color) != 3) {
            // White by default
            $color = [255, 255, 255];
        }

        $resource = imagecreatetruecolor($width, $height);
        $background_color = imagecolorallocate($resource, ...$color);

        $dest_x = (int)($width-$this->getWidth())/2;
        $dest_y = (int)($height-$this->getHeight())/2;
        imagefill($resource, 0, 0, $background_color);
        imagecopy($resource, $this->resource, $dest_x, $dest_y, 0, 0, $this->dimensions['width'], $this->dimensions['height']);

        $this->resource = $resource;
        $this->dimensions['width'] = $width;
        $this->dimensions['height'] = $height;

        return $this;
    }

    // 1200x1000->resize(150, 100)
    public function resize($width, $height, $maintain_aspect_ratio=true)
    {
        if (!$width && !$height) {
            throw new \Exception("Image.resize requires at least a width or a height");
        }

        if (!$width) {
            // Automatically set width to maintain aspect ratio
            $width = (int)$this->dimensions['width']*($height/$this->dimensions['height']);
        }

        if (!$height) {
            // Automatically set height to maintain aspect ratio
            $height = (int)$this->dimensions['height']*($width/$this->dimensions['width']);
        }

        // dump("RESIZE {$this->getWidth()}x{$this->getHeight()} to {$width}x{$height}");

        // 120 != 1000*(100/1000)
        $match_aspect_ratio = ($height == (int)($this->dimensions['height']*($width/$this->dimensions['width'])));
        dump($match_aspect_ratio);
        if ($maintain_aspect_ratio && !$match_aspect_ratio) {
            $height_ratio = $height/$this->dimensions['height'];
            $width_ratio = $width/$this->dimensions['width'];
            if ($height_ratio > $width_ratio) {
                // Need horizontal bars to pad height
                $w = $this->dimensions['width'];
                $h = $height * ($this->dimensions['width']/$width);
                // dump("PAD HEIGHT TO {$w}x{$h}");
            } else {
                // Need vertical bars to pad width
                $w = $width * ($this->dimensions['height']/$height);
                $h = $this->dimensions['height'];
                // dump("PAD WIDTH TO {$w}x{$h}");
            }

            // Pad with white to maintain aspect ratio
            $this->padTo($w, $h);
        }

        if (function_exists("imagecreatetruecolor")) {
            $resource = imagecreatetruecolor($width, $height);
        } else {
            $resource = imagecreate($width, $height);
        }
        imagealphablending($resource, false);
        imagesavealpha($resource, true);
        // http://php.net/manual/en/function.imagecopyresized.php
        // If the source and destination coordinates and width and heights
        // differ, appropriate stretching or shrinking of the image fragment
        // will be performed.
        imagecopyresized(
            $resource,                      // destination
            $this->resource,                // source
            0,
            0,
            0,
            0,
            $width,                         // dest width
            $height,                        // dest height
            $this->dimensions['width'],     // src width
            $this->dimensions['height']     // src height
        );

        $this->resource = $resource;
        $this->dimensions['width'] = $width;
        $this->dimensions['height'] = $height;

        return $this;
    }

    public function rotate($direction='CW')
    {
        if ($direction == 'CW') {
            $resource = imagerotate($resource,-90,0);
        } else {
            $resource = imagerotate($resource,90,0);
        }
        $this->resource = $resource;

        $width = $this->dimensions['height'];
        $height = $this->dimensions['width'];
        $this->dimensions['width'] = $width;
        $this->dimensions['height'] = $height;

        return $this;
    }

    public function scale($by)
    {
        $width = $by * $this->dimensions['width'];
        $height = $by * $this->dimensions['height'];

        if (function_exists("imagecreatetruecolor")) {
            $working = imagecreatetruecolor($width, $height);
        } else {
            $working = imagecreate($width, $height);
        }

        imagealphablending($working, false);
        imagesavealpha($working, true);
        imagecopyresampled(
            $working,
            $this->resource,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $this->dimensions['width'],
            $this->dimensions['height']
        );

        $this->resource = $working;
        $this->dimensions['width'] = $width;
        $this->dimensions['height'] = $height;

        return $this;
    }
}
