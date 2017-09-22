<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public static function boot() {
        static::created(function (User $user) {
            $roles = Role::where('code', 'user')->get();
            $user->roles()->attach($roles);
        });

        parent::boot();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function hasAccess($resource_code)
    {
        $roles = $this->roles;
        foreach ($roles as $role) {
            $resources = $role->resources;
            foreach ($resources as $resource) {
                if ($resource->code == $resource_code) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
