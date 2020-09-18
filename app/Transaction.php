<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $guarded = [];
    protected $fillable = ['subscription_active_flag'];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productOptions()
    {
        return $this->belongsToMany(ProductOption::class, 'transaction_product_option');
    }

    public function transaction_product_options()
    {
        return $this->hasMany(TransactionProductOption::class);
    }
}
