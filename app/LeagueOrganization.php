<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueOrganization extends Model
{
    protected $table = 'league_organization';
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
