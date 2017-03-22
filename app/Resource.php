<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $guarded = [
        'code',
        'description'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
