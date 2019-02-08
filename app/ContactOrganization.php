<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ContactOrganization extends Model
{
    protected $table = 'contact_organization';
    protected $guarded = [];
    protected $hidden = [];
}
