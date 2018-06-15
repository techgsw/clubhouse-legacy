<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    protected $table = 'organization_type';
    protected $fillable = ['name','code'];

    // Relationships

    public function organizations()
    {
        return $this->hasOne(Organization::class);
    }
}
