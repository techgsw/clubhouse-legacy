<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $fillable = [
        'influencer',
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
