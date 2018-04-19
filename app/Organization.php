<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organization';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'name',
        'city',
        'state',
        'country'
    ];

    public function jobs()
    {
        return $this->belongsToMany(Jobs::class);
    }

    public function leagues()
    {
        return $this->belongsToMany(League::class);
    }
}
