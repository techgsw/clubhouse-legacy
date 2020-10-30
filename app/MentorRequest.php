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

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
