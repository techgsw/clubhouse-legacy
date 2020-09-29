<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [
        'code',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }
}
