<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagType extends Model
{
    protected $table = 'tag_type';
    protected $guarded = [];
    public $timestamps = false;
    
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}

