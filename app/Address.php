<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];

    public function profile()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function contact()
    {
        return $this->belongsToMany(Contact::class);
    }

    public function equals(Address $address)
    {
        return $this->line1 === $address->line1
            && $this->line2 === $address->line2
            && $this->city === $address->city
            && $this->state === $address->state
            && $this->postal_code === $address->postal_code
            && $this->country === $address->country;
    }
}
