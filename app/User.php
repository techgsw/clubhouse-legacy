<?php

namespace App;

use App\Mail\UserPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'user';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'last_login_at'
    ];

    public static function boot() {
        static::created(function (User $user) {
            $roles = Role::where('code', 'user')->get();
            $user->roles()->attach($roles);
        });

        static::deleted(function(User $user) {
            $contact = Contact::where('user_id', $user->id);
            $contact->delete();
        });

        parent::boot();
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class)->withPivot('pro');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('created_at');
    }

    public function role_user()
    {
        return $this->hasMany(RoleUser::class);
    }

    public function postings()
    {
        return $this->hasMany(Job::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function mentorRequests()
    {
        return $this->hasMany(MentorRequest::class);
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

    public function hasRole($roleName)
    {
        return $this->role_user->contains(function ($roleUser) use ($roleName) {
            return $roleUser->role_code === $roleName;
        });
    }

    public function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getTitle()
    {
        if (!$this->profile) {
            return null;
        }
        if (!is_null($this->profile->current_title) || !is_null($this->profile->current_organization)) {
            return ($this->profile->current_title ?: 'Works') . ($this->profile->current_organization ? ' at ' . $this->profile->current_organization : '');
        }
        return null;
    }

    public static function search(Request $request)
    {
        $users = User::join('profile', 'profile.user_id', '=', 'user.id')
            // ->join('note', function ($join) {
            //     $join->on('note.notable_id', '=', 'profile.id')->where('note.notable_type', '=', 'App\Profile')->latest();
            // })
            // Yooo whaaat https://github.com/laravel/framework/issues/4962
            ->select('profile.*', 'user.*');

        $term = $request->query->get('term');
        $index = $request->query->get('index') ?: 'name';

        switch ($index) {
        case 'id':
            $term = (int)$term;
            $users = $users->where('user.id', $term);
            break;
        case 'organization':
            $users = $users->where('profile.current_organization', 'like', "%$term%");
            break;
        case 'title':
            $users = $users->where('profile.current_title', 'like', "%$term%");
            break;
        case 'email':
            $users = $users->where('user.email', 'like', "%$term%");
            break;
        case 'name':
        default:
            $users = $users->where(DB::raw('CONCAT(user.first_name, " ", user.last_name)'), 'like', "%$term%");
        }

        $sort = $request->query->get('sort');
        switch ($sort) {
        case 'id-desc':
            $users = $users->orderBy('user.id', 'desc');
            break;
        case 'id-asc':
            $users = $users->orderBy('user.id', 'asc');
            break;
        case 'email-desc':
            $users = $users->orderBy('user.email', 'desc');
            break;
        case 'email-asc':
            $users = $users->orderBy('user.email', 'asc');
            break;
        case 'name-desc':
            $users = $users->orderBy('user.last_name', 'desc');
            break;
        case 'name-asc':
            $users = $users->orderBy('user.last_name', 'asc');
            break;
        default:
            $users = $users->orderBy('user.id', 'desc');
            break;
        }

        $job_seeking_type = $request->query->get('job_seeking_type');
        switch ($job_seeking_type) {
        case 'internship':
            $users = $users->where('profile.job_seeking_type', 'internship');
            break;
        case 'entry_level':
            $users = $users->where('profile.job_seeking_type', 'entry_level');
            break;
        case 'mid_level':
            $users = $users->where('profile.job_seeking_type', 'mid_level');
            break;
        case 'entry_level_management':
            $users = $users->where('profile.job_seeking_type', 'entry_level_management');
            break;
        case 'mid_level_management':
            $users = $users->where('profile.job_seeking_type', 'mid_level_management');
            break;
        case 'executive':
            $users = $users->where('profile.job_seeking_type', 'executive');
            break;
        case 'all':
        default:
            break;
        }

        $job_seeking_status = $request->query->get('job_seeking_status');
        switch ($job_seeking_status) {
        case 'unemployed':
            $users = $users->where('profile.job_seeking_status', 'unemployed');
            break;
        case 'employed_active':
            $users = $users->where('profile.job_seeking_status', 'employed_active');
            break;
        case 'employed_passive':
            $users = $users->where('profile.job_seeking_status', 'employed_passive');
            break;
        case 'employed_future':
            $users = $users->where('profile.job_seeking_status', 'employed_future');
            break;
        case 'employed_not':
            $users = $users->where('profile.job_seeking_status', 'employed_not');
            break;
        case 'all':
        default:
            break;
        }

        return $users;
    }

    public static function registeredOn(\DateTime $date)
    {
        $users = User::where('created_at', '>=', $date->format('Y-m-d 00:00:00'))
            ->where('created_at', '<=', $date->format('Y-m-d 23:59:59'));
        return $users;
    }

    public function noteCount()
    {
        return count(Note::profile($this->id));
    }

    public function authoredNoteCount($start_date, $end_date)
    {
        $notes = $this->hasMany(Note::class)
            ->where('note.created_at', '>=', $start_date->format('Y-m-d 00:00:00'))
            ->where('note.created_at','<=', $end_date->format('Y-m-d 23:59:59'));
        return $notes->count();
    }

    /**
     * Override for a custom password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        \Mail::to($this)->send(new UserPasswordReset($this, $token));
    }

    public function linkUsersToThisAccount($users) {
        // use the email/phone of the first contact in the list as the secondary email and secondary phone of this account
        $primary_contact = $this->contact;
        $primary_contact->secondary_email = $users[0]->email;
        $primary_contact->secondary_phone = $users[0]->contact->phone;
        $primary_contact->save();
        foreach($users as $user) {
            foreach(Note::contact($user->contact->id) as $note) {
                $note->notable_id = $primary_contact->id;
                $note->save();
            }
            $user->linked_user_id = $this->id;
            $user->save();
        }
    }
}
