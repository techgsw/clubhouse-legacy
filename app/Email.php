<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Email extends Model
{
    protected $table = 'email';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
