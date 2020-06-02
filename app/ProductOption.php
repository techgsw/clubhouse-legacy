<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'product_option';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'product_option_role');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_product_option');
    }

    public function hasRole($role_code)
    {
        foreach ($this->roles as $role) {
            if ($role->code == $role_code) {
                return true;
            }
        }

        return false;
    }

    public function getURL($absolute = false, $root = 'product')
    {
        $url = "/".$root."/" . $this->id . "-" . preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', ucwords($this->name)));
        if ($absolute) {
            $url = url($url);
        }
        return $url;
    }
}
