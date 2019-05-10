<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionProductOption extends Model
{
    protected $table = 'transaction_product_option';
    public $timestamps = false;


    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product_option()
    {
        return $this->belongsTo(ProductOption::class);
    }
}
