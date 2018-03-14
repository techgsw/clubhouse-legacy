<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $table = 'post';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function isNew()
    {
        $new = (new \DateTime('NOW'))->sub(new \DateInterval('P14D'));
        return $this->created_at > $new;
    }

    public static function search(Request $request)
    {
        // TODO published, e.g. $posts = Post::where('published', true);

        if (request('tag')) {
            $tag = request('tag');
            $posts = Post::whereHas('tags', function ($query) use ($tag) {
                $query->where('slug', $tag);
                $query->where('post_type_code', 'blog');
            });
        } else {
            $posts = Post::where('id', '>', 0)->where('post_type_code', '=', 'blog');
        }

        if (request('search')) {
            $search = request('search');
            $posts->whereRaw("MATCH(`title`,`body`) AGAINST (? IN BOOLEAN MODE)", [$search]);
        }

        return $posts->orderBy('post.created_at', 'desc');
    }

    public function getURL()
    {
        return "/blog/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->title)));
    }

    public function getImagePath(PostImage $image = null, $size = 'medium')
    {
        if (is_null($image)) {
            return null;
        }

        $image_path = '/post/'.$image->post_id.'/';

        if ($image->cdn_upload) {
        } else {
            if ($image->legacy) {
                switch ($size) {
                    case 'medium':
                        $image_path .= preg_replace('/\./', '-200x150.', $image->filename);
                        break;
                    default:
                        $image_path .= $image->filename;
                }
            } else {
                if ($size) {
                    $image_path .= $size.'-'.$image->filename;
                } else {
                    $image_path .= $image->filename;
                }
            }
        }

        return $image_path;
    }
}
