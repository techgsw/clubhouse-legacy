<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    protected $table = 'setting';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
