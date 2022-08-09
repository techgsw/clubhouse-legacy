<?php

namespace App;

use App\Exceptions\InvalidSearchException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contact';
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = [
        'follow_up_date'
    ];

    public function headshotImage()
    {
        return $this->belongsTo(Image::class);
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function followUpUser()
    {
        return $this->belongsTo(User::class, 'follow_up_user_id', 'id');
    }

    public function address()
    {
        return $this->belongsToMany(Address::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function relationships()
    {
        return $this->belongsToMany('App\User', 'contact_relationship');
    }

    public function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getTitle()
    {
        if (!is_null($this->title) || !is_null($this->organization)) {
            return ($this->title ?: 'Works') . ($this->organization ? ' at ' . $this->organization : '');
        }
        return null;
    }

    public function jobs()
    {
        return $this->hasMany(ContactJob::class);
    }

    public function getNoteCount()
    {
        return count(Note::contact($this->id));
    }

    public function emailPreferenceTagTypes()
    {
        return $this->belongsToMany(TagType::class, 'contact_email_preference_tag_type');
    }

    public function getJobSeekingStatus()
    {
        $statuses = Profile::getJobSeekingStatuses();

        return isset($statuses[$this->job_seeking_status])
            ? $statuses[$this->job_seeking_status]
            : null;
    }

    public function getJobSeekingType()
    {
        $types = Profile::getJobSeekingTypes();

        return isset($types[$this->job_seeking_type])
            ? $types[$this->job_seeking_type]
            : null;
    }

    public function matches(Profile $profile)
    {
        return
            // User
            $this->first_name === $profile->user->first_name
            && $this->last_name === $profile->user->last_name
            && $this->phone === $profile->phone
            // Profile
            && $this->organization === $profile->current_organization
            && $this->title === $profile->current_title
            && $this->job_seeking_status === $profile->job_seeking_status
            && $this->job_seeking_type === $profile->job_seeking_type
            // Address
            && $this->address[0]->line1 === $profile->address[0]->line1
            && $this->address[0]->line2 === $profile->address[0]->line2
            && $this->address[0]->city === $profile->address[0]->city
            && $this->address[0]->state === $profile->address[0]->state
            && $this->address[0]->postal_code === $profile->address[0]->postal_code
            && $this->address[0]->country === $profile->address[0]->country;
    }

    public function unsyncedInfo(Profile $profile, $subset = null)
    {
        if ($this->updated_at > $profile->updated_at) {
            // No new information since last save
            return false;
        }

        $personal_match =
            (is_null($profile->user->first_name) || $this->first_name === $profile->user->first_name)
            && (is_null($profile->user->last_name) || $this->last_name === $profile->user->last_name)
            && (is_null($profile->phone) || $this->phone === $profile->phone);

        $employment_match =
            (is_null($profile->current_organization) || $this->organization === $profile->current_organization)
            && (is_null($profile->current_title) || $this->title === $profile->current_title)
            && (is_null($profile->job_seeking_status) || $this->job_seeking_status === $profile->job_seeking_status)
            && (is_null($profile->job_seeking_type) || $this->job_seeking_type === $profile->job_seeking_type);

        $address_match =
            (is_null($profile->address[0]->line1) || $this->address[0]->line1 === $profile->address[0]->line1)
            && (is_null($profile->address[0]->line2) || $this->address[0]->line2 === $profile->address[0]->line2)
            && (is_null($profile->address[0]->city) || $this->address[0]->city === $profile->address[0]->city)
            && (is_null($profile->address[0]->state) || $this->address[0]->state === $profile->address[0]->state)
            && (is_null($profile->address[0]->postal_code) || $this->address[0]->postal_code === $profile->address[0]->postal_code)
            && (is_null($profile->address[0]->country) || $this->address[0]->country === $profile->address[0]->country);

        switch ($subset) {
        case 'personal':
            return !$personal_match;
        case 'employment':
            return !$employment_match;
        case 'address':
            return !$address_match;
        }

        return !$personal_match || !$employment_match || !address_match;
    }

    public static function search($sort_type, $searches)
    {
        $contacts = Contact::where('contact.id', '>', 0);

        $contacts = self::buildWhere($contacts, $searches);

        switch ($sort_type) {
            case 'id-desc':
                $contacts = $contacts->orderBy('contact.id', 'desc');
                break;
            case 'id-asc':
                $contacts = $contacts->orderBy('contact.id', 'asc');
                break;
            case 'email-desc':
                $contacts = $contacts->orderBy('contact.email', 'desc');
                break;
            case 'email-asc':
                $contacts = $contacts->orderBy('contact.email', 'asc');
                break;
            case 'name-desc':
                $contacts = $contacts->orderBy('contact.last_name', 'desc');
                break;
            case 'name-asc':
                $contacts = $contacts->orderBy('contact.last_name', 'asc');
                break;
            case 'creation-date-desc':
                $contacts = $contacts->orderBy('contact.created_at', 'desc');
                break;
            case 'last-login-date-desc':
                $contacts = $contacts->whereNotNull('contact.user_id');
                $contacts = $contacts->orderByRaw("CASE "
                        ."WHEN linked_user.id IS NULL THEN contact_user.last_login_at "
                        ."ELSE GREATEST(contact_user.last_login_at, linked_user.last_login_at) "
                    ."END "
                ."DESC");
                break;
            case 'last-profile-update-date-desc':
                $contacts = $contacts->whereNotNull('contact.user_id');
                $contacts = $contacts->orderBy('contact_user_profile.updated_at','DESC');
                break;
            default:
                $contacts = $contacts->orderBy('contact.id', 'desc');
                break;
        }

        // joins can't be added into subqueries, so they can't be included in the recursive buildWhere
        // there also isn't a good way to look up column usage without recursively searching through
        // subqueries in getQuery()->wheres. so we need to check the sql output for the column.
        $query_string = $contacts->toSql();
        if (strpos($query_string, 'contact_note') !== false) {
            $contacts->join('note AS contact_note', function ($join_note) {
                return $join_note->on('contact.id', '=', 'contact_note.notable_id')
                    ->where('contact_note.notable_type', '=', 'App\\Contact');
            });
        }
        if (strpos($query_string, 'contact_owner') !== false) {
            $contacts->join('contact_relationship', 'contact.id', '=', 'contact_relationship.contact_id')
                ->join('user AS contact_owner', 'contact_relationship.user_id', '=', 'contact_owner.id');
        }
        if (strpos($query_string, 'contact_address') !== false) {
            $contacts->join('address_contact', 'contact.id', '=', 'address_contact.contact_id')
                ->join('address AS contact_address', 'address_contact.address_id', '=', 'contact_address.id');
        }
        $contacts->leftJoin('user AS contact_user', 'contact.user_id', '=', 'contact_user.id');
        $contacts->leftJoin('user AS linked_user', 'contact_user.id', '=', 'linked_user.linked_user_id');
        if ($sort_type == 'last-profile-update-date-desc' ||
            strpos($query_string, 'gender') !== false ||
            strpos($query_string, 'job_seeking_region') !== false ||
            strpos($query_string, 'tag_type') !== false ||
            strpos($query_string, 'ethnicity') !== false) {
            $contacts->leftJoin('profile AS contact_user_profile', 'contact_user.id', 'contact_user_profile.user_id');
        }
        $contacts->whereNull('contact_user.linked_user_id');
        // we need to check all linked users for a last login date to display on the main contact entry.
        // the second selected value here can be accessed with $contact->last_login_at
        return $contacts->selectRaw('contact.*, COALESCE(GREATEST(contact_user.last_login_at, linked_user.last_login_at), contact_user.last_login_at) AS last_login_at');

    }

    private static function buildWhere($query, $searches) {
        foreach ($searches as $search_key => $search) {
            $search_value = $search->getValue();
            $conjunction = strtolower($search->getConjunction());
            $label = $search->getLabel();
            switch ($label) {
                case 'id':
                    $search_value = (int)$search_value;
                    $query = $query->where('contact.id', '=', $search_value, $conjunction);
                    break;
                case 'title':
                    $query = $query->where('contact.title', 'like', "%$search_value%", $conjunction);
                    break;
                case 'email':
                    $query = $query->where('contact.email', 'like', "%$search_value%", $conjunction);
                    break;
                case 'secondary_email':
                    $query = $query->where('contact.secondary_email', 'like', "%$search_value%", $conjunction);
                    break;
                case 'owner':
                    $query = $query->where(DB::raw('CONCAT(contact_owner.first_name, " ", contact_owner.last_name)'), 'like', "%$search_value%", $conjunction);
                    break;
                case 'note':
                    $query = $query->where('contact_note.content', 'like', "%$search_value%", $conjunction);
                    break;
                case 'location':
                    $query = $query->where(DB::raw('CONCAT(COALESCE(contact_address.line1, " "), " ", '
                        .'COALESCE(contact_address.line2, " "), " ", '
                        .'COALESCE(contact_address.city, " "), " ", '
                        .'COALESCE(contact_address.state, " "), " ", '
                        .'COALESCE(contact_address.postal_code, " "), " ", '
                        .'COALESCE(contact_address.country, " "), " ")'), 'like', "%$search_value%", $conjunction);
                    break;
                case 'organization':
                    $query = $query->where('contact.organization', 'like', "%$search_value%", $conjunction);
                    break;
                case 'job_seeking_type':
                    switch ($search_value) {
                        case 'internship':
                        case 'entry_level':
                        case 'mid_level':
                        case 'entry_level_management':
                        case 'mid_level_management':
                        case 'executive':
                            $query = $query->where('contact.job_seeking_type', '=', $search_value, $conjunction);
                            break;
                        case 'all':
                        default:
                            break;
                    }
                    break;
                case 'job_seeking_status':
                    switch ($search_value) {
                        case 'unemployed':
                        case 'employed_active':
                        case 'employed_passive':
                        case 'employed_future':
                        case 'employed_not':
                            $query = $query->where('contact.job_seeking_status', '=', $search_value, $conjunction);
                            break;
                        case 'all':
                        default:
                            break;
                    }
                    break;
                case 'job_seeking_region':
                    switch ($search_value) {
                        case 'southwest':
                            $query = $query->where(function ($query) use ($conjunction) {
                                $query->where('contact_user_profile.job_seeking_region', '=', 'sw', $conjunction)
                                      ->orWhere('contact.job_seeking_region', '=', 'sw');
                            });
                            break;
                        case 'northwest':
                            $query = $query->where(function ($query) use ($conjunction) {
                                $query->where('contact_user_profile.job_seeking_region', '=', 'nw', $conjunction)
                                      ->orWhere('contact.job_seeking_region', '=', 'nw');
                            });
                            break;
                        case 'northeast':
                            $query = $query->where(function ($query) use ($conjunction) {
                                $query->where('contact_user_profile.job_seeking_region', '=', 'ne', $conjunction)
                                      ->orWhere('contact.job_seeking_region', '=', 'ne');
                            });
                            break;
                        case 'southeast':
                            $query = $query->where(function ($query) use ($conjunction) {
                                $query->where('contact_user_profile.job_seeking_region', '=', 'se', $conjunction)
                                      ->orWhere('contact.job_seeking_region', '=', 'se');
                            });
                            break;
                        case 'midwest':
                            $query = $query->where(function ($query) use ($conjunction) {
                                $query->where('contact_user_profile.job_seeking_region', '=', 'mw', $conjunction)
                                      ->orWhere('contact.job_seeking_region', '=', 'mw');
                            });
                            break;
                        default:
                            break;
                    }
                    break;
                case 'job_discipline_preference':
                    $query = $query->where(function($query) use($search_value, $conjunction) {
                        $query->whereIn('contact_user_profile.id', function($query) use ($search_value) {
                                  $query->select('profile_email_preference_tag_type.profile_id')
                                        ->from('profile_email_preference_tag_type')
                                        ->leftJoin('tag_type', 'profile_email_preference_tag_type.tag_type_id', 'tag_type.id')
                                        ->where('tag_type.tag_name', $search_value);
                                  }, $conjunction)
                              ->whereIn('contact.id', function($query) use ($search_value) {
                                  $query->select('contact_email_preference_tag_type.contact_id')
                                        ->from('contact_email_preference_tag_type')
                                        ->leftJoin('tag_type', 'contact_email_preference_tag_type.tag_type_id', 'tag_type.id')
                                        ->where('tag_type.tag_name', $search_value);
                                  }, 'or');
                    });
                    break;
                case 'gender':
                    $query = $query->where(function($query) use ($search_value, $conjunction) {
                        $query->where('contact_user_profile.gender', '=', $search_value, $conjunction)
                              ->orWhere('contact.gender', '=', $search_value);
                    });
                    break;
                case 'ethnicity':
                    $query = $query->where(function($query) use ($search_value, $conjunction) {
                        $query->where('contact_user_profile.ethnicity', '=', $search_value, $conjunction)
                              ->orWhere('contact.ethnicity', '=', $search_value);
                    });
                    break;
                case Search::GROUP_LABEL:
                    if ($conjunction === "and") {
                        $query = $query->where(function($query) use ($search_value) {
                            return self::buildWhere($query, $search_value);
                        });
                    } else if ($conjunction === "or") {
                        $query = $query->orWhere(function($query) use ($search_value) {
                            return self::buildWhere($query, $search_value);
                        });
                    }
                    break;
                case 'name':
                case Search::DEFAULT_LABEL:
                    $query = $query->where(DB::raw('CONCAT(contact.first_name, " ", contact.last_name)'), 'like', "%$search_value%", $conjunction);
                    break;
                default:
                    throw new InvalidSearchException("Label ".$label." does not exist.");
            }
        }
        return $query;
    }
}
