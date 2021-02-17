<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $guarded = [];
    protected $dates = [];
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class, 'mentor_tag');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_tag');
    }

    public function tagType()
    {
        return $this->hasMany(TagType::class);
    }
}
