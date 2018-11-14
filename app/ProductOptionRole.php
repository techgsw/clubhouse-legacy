<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOptionRole extends Model
{
    protected $table = 'product_option_role';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
