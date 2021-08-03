<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
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

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public static function approved()
    {
        return Question::where('approved', true)->orderBy('created_at', 'desc');
    }

    public static function unapproved()
    {
        return Question::whereNull('approved')->orderBy('created_at', 'asc');
    }

    public static function search(Request $request)
    {
        $questions = Question::where('approved', true);

        if (request('search')) {
            $search = request('search');
            $questions->whereRaw("MATCH(`title`,`body`) AGAINST ('%?%' IN BOOLEAN MODE)", [$search]);
        }

        return $questions->orderBy('created_at', 'desc');
    }
}
