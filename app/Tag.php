<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $guarded = [];
    protected $dates = [];
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
