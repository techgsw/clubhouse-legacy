<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Session extends Model
{
    protected $table = 'session';
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
}
