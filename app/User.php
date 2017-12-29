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

    public function notes()
    {
        return $this->morphMany('App\Note', 'notable');
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

    public function hasCompleteProfile()
    {
        $personal_complete =
            $this->profile->date_of_birth &&
            $this->profile->ethnicity &&
            $this->profile->gender;

        $address_complete =
            $this->address->line1 &&
            $this->address->city &&
            $this->address->state &&
            $this->address->postal_code &&
            $this->address->country;

        $job_preferences_complete =
            $this->profile->job_seeking_status &&
            $this->profile->job_seeking_type &&
            $this->profile->job_seeking_region && (
                // At least one department goal
                $this->profile->department_goals_ticket_sales ||
                $this->profile->department_goals_sponsorship_sales ||
                $this->profile->department_goals_service ||
                $this->profile->department_goals_premium_sales ||
                $this->profile->department_goals_marketing ||
                $this->profile->department_goals_sponsorship_activation ||
                $this->profile->department_goals_hr ||
                $this->profile->department_goals_analytics ||
                $this->profile->department_goals_cr ||
                $this->profile->department_goals_pr ||
                $this->profile->department_goals_database ||
                $this->profile->department_goals_finance ||
                $this->profile->department_goals_arena_ops ||
                $this->profile->department_goals_player_ops ||
                $this->profile->department_goals_event_ops ||
                $this->profile->department_goals_social_media ||
                $this->profile->department_goals_entertainment ||
                $this->profile->department_goals_legal ||
                $this->profile->department_goals_other
            ) && (
                // At least one job factor
                $this->profile->job_factors_money ||
                $this->profile->job_factors_title ||
                $this->profile->job_factors_location ||
                $this->profile->job_factors_organization ||
                $this->profile->job_factors_other
            );

        $employment_complete =
            !is_null($this->profile->works_in_sports) &&
            $this->profile->current_organization &&
            $this->profile->current_title &&
            $this->profile->current_region &&
            $this->profile->current_organization_years &&
            $this->profile->current_title_years && (
                // At least one department experience
                $this->profile->department_experience_ticket_sales ||
                $this->profile->department_experience_sponsorship_sales ||
                $this->profile->department_experience_service ||
                $this->profile->department_experience_premium_sales ||
                $this->profile->department_experience_marketing ||
                $this->profile->department_experience_sponsorship_activation ||
                $this->profile->department_experience_hr ||
                $this->profile->department_experience_analytics ||
                $this->profile->department_experience_cr ||
                $this->profile->department_experience_pr ||
                $this->profile->department_experience_database ||
                $this->profile->department_experience_finance ||
                $this->profile->department_experience_arena_ops ||
                $this->profile->department_experience_player_ops ||
                $this->profile->department_experience_event_ops ||
                $this->profile->department_experience_social_media ||
                $this->profile->department_experience_entertainment ||
                $this->profile->department_experience_legal ||
                $this->profile->department_experience_other
            );

        $education_complete =
            $this->profile->education_level &&
            $this->profile->college_name &&
            $this->profile->college_graduation_year &&
            $this->profile->college_gpa &&
            $this->profile->college_organizations &&
            $this->profile->college_sports_clubs &&
            !is_null($this->profile->has_school_plans);

        $complete =
            $personal_complete &&
            $address_complete &&
            $job_preferences_complete &&
            $employment_complete &&
            $education_complete;

        return $complete;
    }

    public static function search(Request $request)
    {
        $users = User::where('id', '>', 0);

        if ($term = $request->query->get('term')) {
            if (ctype_digit($term)) {
                $term = (int)$term;
                $users = $users->where('id', $term);
            } else {
                $users = $users->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', "%$term%");
                $users = $users->orWhere('email', 'like', "%$term%");
            }
        }

        if ($sort = $request->query->get('sort')) {
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
