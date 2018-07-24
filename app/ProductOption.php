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

    public function hasRole($role_code)
    {
        foreach ($this->roles as $role) {
            if ($role->code == $role_code) {
                return true;
            }
        }

        return false;
    }
}
