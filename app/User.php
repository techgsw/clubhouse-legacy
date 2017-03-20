<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Represents relationship between User and Questions
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Represents relationship between User and Answers
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
