<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $guarded = [
        'approved'
    ];

    /**
     * Represents relationship between Question and User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
