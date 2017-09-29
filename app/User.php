<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

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

    public static function search(Request $request)
    {
        $users = User::where('id', '>', 0);

        if ($term = request('term')) {
            if (ctype_digit($term)) {
                $term = (int)$term;
                $users = $users->where('id', $term);
            } else {
                $users = $users->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', "%$term%");
                $users = $users->orWhere('email', 'like', "%$term%");
            }
        }

        if ($sort = request('sort')) {
            switch ($sort) {
                case 'id-desc':
                    $users = $users->orderBy('id', 'desc');
                    break;
                case 'id-asc':
                    $users = $users->orderBy('id', 'asc');
                    break;
                case 'email-desc':
                    $users = $users->orderBy('email', 'desc');
                    break;
                case 'email-asc':
                    $users = $users->orderBy('email', 'asc');
                    break;
                case 'name-desc':
                    $users = $users->orderBy('last_name', 'desc');
                    break;
                case 'name-asc':
                    $users = $users->orderBy('last_name', 'asc');
                    break;
                default:
                    $users = $users->orderBy('id', 'asc');
                    break;
            }
        }

        return $users;
    }
}
