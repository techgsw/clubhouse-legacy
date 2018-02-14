<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $guarded = [
        // TODO
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
