<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Parsedown;

class Post extends Model
{
    protected $table = 'post';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];

    protected $attributes = ['blurb'];

    public function getBlurbAttribute()
    {
        $parsedown = new Parsedown();
        $body = strip_tags($parsedown->text($this->body));
        $post_length = strlen($body);
        $index = 200;
        // Break into words
        while (!preg_match('/\s/', $body[$index]) && $post_length > $index) {
            $index++;
        }

        return substr($body, 0, $index) . '&hellip;';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'post_image', 'post_id', 'image_id')->withPivot('caption', 'alt', 'is_primary')->orderBy('order');
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
        $posts = Post::where('id', '>', 0)->where('post_type_code', '=', 'blog');

        if (request('search')) {
            $search = request('search');
            $posts->whereRaw("title LIKE '%?%' OR body LIKE '%?%'", [$search]);
        }

        return $posts->orderBy('post.created_at', 'desc');
    }

    public function getURL()
    {
        return "/blog/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->title)));
    }

    public function getPrimaryImage()
    {
        return $this->belongsToMany(Image::class, 'post_image', 'post_id', 'image_id')->withPivot('caption', 'alt', 'is_primary')->where('is_primary', 1)->orderBy('post_image.id', 'DESC')->first();
    }
}
