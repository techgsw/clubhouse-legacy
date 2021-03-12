<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'edited_at'
    ];
    protected $casts = [
        'planned_services' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsToMany(Address::class);
    }

    public function headshotImage()
    {
        return $this->belongsTo(Image::class);
    }

    public function notes()
    {
        return $this->morphMany('App\Note', 'notable');
    }

    public function emailPreferenceTagTypes()
    {
        return $this->belongsToMany(TagType::class, 'profile_email_preference_tag_type');
    }

    public function getJobSeekingStatus()
    {
        switch ($this->job_seeking_status) {
        case "unemployed":
            return "Unemployed";
        case "employed_active":
            return "Employed, actively seeking a new job";
        case "employed_passive":
            return "Employed, passively exploring new opportunities";
        case "employed_future":
            return "Employed, only open to future opportunities";
        case "employed_not":
            return "Employed, currently have my dream job";
        default:
            return '';
        }
    }

    public function getJobSeekingType()
    {
        switch ($this->job_seeking_type) {
        case "internship":
            return "Internship";
        case "entry_level":
            return "Entry-level";
        case "mid_level":
            return "Mid-level";
        case "entry_level_management":
            return "Entry-level management";
        case "mid_level_management":
            return "Mid-level management";
        case "executive":
            return "Executive team";
        default:
            return '';
        }
    }

    public function isPersonalComplete()
    {
        return
            $this->date_of_birth &&
            $this->ethnicity &&
            $this->gender;
    }

    public function isAddressComplete()
    {
        return
            $this->address[0] &&
            $this->address[0]->line1 &&
            $this->address[0]->city &&
            $this->address[0]->state &&
            $this->address[0]->postal_code &&
            $this->address[0]->country;
    }

    public function isJobPreferencesComplete()
    {
        return
            $this->job_seeking_status &&
            $this->job_seeking_type &&
            $this->job_seeking_region && 
            count($this->emailPreferenceTagTypes) > 0 && (
                // At least one job factor
                $this->job_factors_money ||
                $this->job_factors_title ||
                $this->job_factors_location ||
                $this->job_factors_organization ||
                $this->job_factors_other
            );
    }

    public function isEmploymentComplete()
    {
        return
            !is_null($this->works_in_sports) &&
            $this->current_organization &&
            $this->current_title &&
            $this->current_region &&
            $this->current_organization_years &&
            $this->current_title_years && (
                // At least one department experience
                $this->department_experience_ticket_sales ||
                $this->department_experience_sponsorship_sales ||
                $this->department_experience_service ||
                $this->department_experience_premium_sales ||
                $this->department_experience_marketing ||
                $this->department_experience_sponsorship_activation ||
                $this->department_experience_hr ||
                $this->department_experience_analytics ||
                $this->department_experience_cr ||
                $this->department_experience_pr ||
                $this->department_experience_database ||
                $this->department_experience_finance ||
                $this->department_experience_arena_ops ||
                $this->department_experience_player_ops ||
                $this->department_experience_event_ops ||
                $this->department_experience_social_media ||
                $this->department_experience_entertainment ||
                $this->department_experience_legal ||
                $this->department_experience_other
            );
    }

    public function isEducationComplete()
    {
        return
            $this->education_level &&
            !is_null($this->has_school_plans);
    }

    public function isComplete()
    {
        return 
            $this->isPersonalComplete() &&
            $this->isAddressComplete() &&
            $this->isJobPreferencesComplete() &&
            $this->isEmploymentComplete();

    }
}
