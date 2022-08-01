<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    protected $jobSeekingStatuses = [
        'unemployed' => 'Unemployed',
        'employed_active' => 'Employed, actively seeking a new job',
        'employed_passive' => 'Employed, passively exploring new opportunities',
        'employed_future' => 'Employed, only open to future opportunities',
        'employed_not' => 'Employed, currently have my dream job',
    ];

    protected $jobSeekingTypes = [
        'internship' => 'Internship',
        'entry_level' => 'Entry Level',
        'management' => 'Manager/SR Manager',
        'director' => 'Director/SR Director',
        'vice_president' => 'VP/SVP/EVP',
        'executive' => 'C-Level',
    ];

    protected $jobSeekingRegions = [
        'any' => 'Any/All',
        'mw' => 'Midwest',
        'ne' => 'Northeast',
        'nw' => 'Northwest',
        'se' => 'Southeast',
        'sw' => 'Southwest',
    ];

    protected $ethnicities = [
        'asian' => 'Asian or Pacific Islander',
        'black' => 'Black or African American',
        'hispanic' => 'Hispanic',
        'native' => 'Native American',
        'white' => 'White or Caucasian',
        'na' => 'Prefer not to answer',
    ];

    protected $genders = [
        'male' => 'Male',
        'female' => 'Female',
        'non-binary' => 'Non-binary',
        'na' => 'Prefer not to answer',
    ];

    protected $departments = [
        'department_experience_arena_ops' => 'Arena Operations',
        'department_experience_event_ops' => 'Building & Event Operations',
        'department_experience_analytics' => 'Business Analytics, CRM & Database',
        'department_experience_pr' => 'Communications/PR',
        'department_experience_cr' => 'Community Relations',
        'department_experience_sponsorship_activation' => 'Corporate Partnerships Sales & Activation',
        'department_experience_database' => 'Database',
        'department_experience_social_media' => 'Digital/Social Media',
        'department_experience_finance' => 'Finance',
        'department_experience_entertainment' => 'Game Entertainment',
        'department_experience_hr' => 'Human Resources',
        'department_experience_legal' => 'Legal Finance Accounting & IT',
        'department_experience_marketing' => 'Marketing, Digital, & Social Media',
        'department_experience_player_ops' => 'Player Operations',
        'department_experience_premium_sales' => 'Premium Sales & Service',
        'department_experience_service' => 'Service',
        'department_experience_sponsorship_sales' => 'Sponsorship Sales',
        'department_experience_ticket_sales' => 'Ticket Sales & Service',
    ];

    public static function getJobSeekingStatuses()
    {
        return (new static())->jobSeekingStatuses;
    }

    public static function getJobSeekingTypes()
    {
        return (new static())->jobSeekingTypes;
    }

    public static function getJobSeekingRegions()
    {
        return (new static())->jobSeekingRegions;
    }

    public static function getEthnicities()
    {
        return (new static())->ethnicities;
    }

    public static function getGenders()
    {
        return (new static())->genders;
    }
    public static function getDepartments()
    {
        $departments = (new static())->departments;
        asort($departments);

        return $departments;
    }

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
        $statuses = self::getJobSeekingStatuses();

        return isset($statuses[$this->job_seeking_status])
            ? $statuses[$this->job_seeking_status]
            : null;
    }

    public function getJobSeekingType()
    {
        $types = self::getJobSeekingTypes();

        return isset($types[$this->job_seeking_type])
            ? $types[$this->job_seeking_type]
            : null;
    }

    public function getJobSeekingRegion()
    {
        $regions = self::getJobSeekingRegions();

        return isset($regions[$this->job_seeking_region])
            ? $regions[$this->job_seeking_region]
            : null;
    }

    public function getGender()
    {
        $genders = self::getGenders();

        return isset($genders[$this->gender])
            ? $genders[$this->gender]
            : null;
    }

    public function getEthnicity()
    {
        $ethnicities = self::getEthnicities();

        return isset($ethnicities[$this->ethnicity])
            ? $ethnicities[$this->ethnicity]
            : null;
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

    public function emailPreferenceTagTypesMatchContact()
    {
        foreach ($this->emailPreferenceTagTypes as $tag_type) {
            if (!$this->user->contact->emailPreferenceTagTypes->contains('id', $tag_type->id)) {
                return false;
            }
        }
        foreach ($this->user->contact->emailPreferenceTagTypes as $tag_type) {
            if (!$this->emailPreferenceTagTypes->contains('id', $tag_type->id)) {
                return false;
            }
        }
        return true;
    }

    public function generateEmailUnsubscribeToken()
    {
        $this->email_unsubscribe_token = hash('sha256', "$this->id $this->user_id ".rand(0,100)*rand(0,100));
    }
}
