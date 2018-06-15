<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $table = 'league';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'abbreviation'
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
