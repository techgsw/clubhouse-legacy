<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'product_image', 'product_id', 'image_id')->orderBy('order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function primaryImage()
    {
        if ($this->images->count() == 0) {
            return null;
        }

        return $this->images[0];
    }
}
