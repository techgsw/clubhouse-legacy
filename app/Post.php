<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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

    public function isNew()
    {
        $new = (new \DateTime('NOW'))->sub(new \DateInterval('P14D'));
        return $this->created_at > $new;
    }

    public function getURL()
    {
        return "/blog/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->title)));
    }
}
