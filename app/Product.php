<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function getCleanDescription()
    {
        $description = $this->description;
        return preg_replace('/sbs-embed-code=.+?(?=(\s|$))/i', '', $description);
    }

    public function getEmbedCode()
    {
        preg_match('/sbs-embed-code=.+?(?=(\s|$))/i', $this->description, $results);

        return ((count($results) > 0) ? preg_replace('/sbs-embed-code=/i', '', $results[0]) : null);
    }

    public function availableOptions($role_code = null)
    {
        if (is_null($role_code)) {
            if (!Auth::user() || !Auth::user()->roles) {
                return [];
            }

            // TODO make this resource-driven, rather than role-driven
            $role_code = 'user';
            foreach (Auth::user()->roles as $r) {
                if ($r->code == 'clubhouse') {
                    $role_code = 'clubhouse';
                }
            }
        }

        $options = clone $this->options;

        foreach ($options as $i => $option) {
            $option_role_codes = [];
            foreach ($option->roles as $r) {
                $option_role_codes[] = $r->code;
            }
            if (count(array_intersect($option_role_codes, [$role_code])) == 0) {
                $options->forget($i);
            }
        }

        return $options;
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

    public function getURL($absolute = false, $root = 'product')
    {
        $url = "/".$root."/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->name)));
        if ($absolute) {
            $url = url($url);
        }
        return $url;
    }

    public function getTrainingVideoAuthor()
    {
        $author = $this->tags->first(function ($tag) {
            return stripos($tag->name, 'Author:') !== false;
        });
        if (!is_null($author)) {
            return str_ireplace('Author:', '', $author->name);
        } else {
            return null;
        }
    }
}
