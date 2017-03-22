<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $guarded = [
        'approved'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public static function approved()
    {
        return Question::where('approved', true)->orderBy('created_at', 'desc')->get();
    }

    public static function unapproved()
    {
        return Question::where('approved', null)->orderBy('created_at', 'asc')->get();
    }
}
