<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];


    public function transaction_product_options()
    {
        return $this->hasMany(TransactionProductOption::class);
    }
}
