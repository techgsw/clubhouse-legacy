<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AddressContact extends Model
{
    protected $table = 'address_contact';
    protected $guarded = [];
    protected $hidden = [];
}
