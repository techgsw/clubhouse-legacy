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

    // Scopes

    public function scopeFilter($query, $params)
    {
        // Match term on name, description, and option names and descriptions
        $term = array_key_exists('term', $params) ? $params['term'] : null;
        if (strlen($term) > 0) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%");
                $q->orWhere('description', 'like', "%{$term}%");
                $q->orWhereHas('options', function ($query) use ($term) {
                    $query->where('name', 'like', "%{$term}%");
                    $query->orWhere('description', 'like', "%{$term}%");
                });
            });
        }

        $status = array_key_exists('status', $params) ? $params['status'] : null;
        switch ($status) {
            case 'active':
                $query->where('active', true);
                break;
            case 'inactive':
                $query->where('active', false);
                break;
            default:
                break;
        }

        $tag = array_key_exists('tag', $params) ? urldecode($params['tag']) : null;
        if (strlen($tag) > 0 && $tag !== 'all') {
            $query->whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            });
        }

        return $query;
    }
}
