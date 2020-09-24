<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentorRequest extends Model
{
    protected $table = 'mentor_request';
    protected $fillable = [
        'user_id',
        'mentor_id'
    ];
}
