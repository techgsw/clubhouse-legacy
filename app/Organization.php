<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organization';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'name'
    ];

    // Relationships

    public function addresses()
    {
        return $this->belongsToMany(Address::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function league()
    {
        return $this->hasOne(League::class);
    }

    public function leagues()
    {
        return $this->belongsToMany(League::class);
    }

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function parentOrganization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Scopes

    public function scopeSearch($query, $request)
    {
        // Match term on name and city
        $term = $request->term;
        if (!empty($term)) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%");
                $q->orWhereHas('addresses', function ($query) use ($term) {
                    $query->where('city', 'like', "%{$term}%");
                });
            });
        }

        return $query;
    }

    // Utilities

    public function isLeague()
    {
        return $this->organizationType->code == 'league';
    }
}
