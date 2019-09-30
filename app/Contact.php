<?php

namespace App;

use App\Exceptions\InvalidSearchException;
use App\Note;
use App\Profile;
use App\Search;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Contact extends Model
{
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
                ->join('user AS contact_owner', function ($join_user) {
                    $join_user->on('contact_relationship.user_id', '=', 'contact_owner.id');
                });
        }
        if (strpos($query_string, 'contact_address') !== false) {
            $contacts->join('address_contact', 'contact.id', '=', 'address_contact.contact_id')
                ->join('address AS contact_address', function ($join_address) {
                    $join_address->on('address_contact.address_id', '=', 'contact_address.id');
                });
        }

        return $contacts->select('contact.*');
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
                case 'owner':
                    $query = $query->where(DB::raw('CONCAT(contact_owner.first_name, " ", contact_owner.last_name)'), 'like', "%$search_value%", $conjunction);
                    break;
                case 'note':
                    $query = $query->where('contact_note.content', 'like', "%$search_value%", $conjunction);
                    break;
                case 'location':
                    $query = $query->where(DB::raw('CONCAT(contact_address.line1, " ", contact_address.line2, " ", contact_address.city, " ", contact_address.state, " ", contact_address.postal_code, " ", contact_address.country, " ")'), 'like', "%$search_value%", $conjunction);
                    break;
                case 'organization':
                    $query = $query->where('contact.organization', 'like', "%$search_value%", $conjunction);
                    break;
                case 'job_seeking_type':
                    switch ($search_value) {
                        case 'internship':
                            $query = $query->where('contact.job_seeking_type', '=', 'internship', $conjunction);
                            break;
                        case 'entry_level':
                            $query = $query->where('contact.job_seeking_type', '=', 'entry_level', $conjunction);
                            break;
                        case 'mid_level':
                            $query = $query->where('contact.job_seeking_type', '=', 'mid_level', $conjunction);
                            break;
                        case 'entry_level_management':
                            $query = $query->where('contact.job_seeking_type', '=', 'entry_level_management', $conjunction);
                            break;
                        case 'mid_level_management':
                            $query = $query->where('contact.job_seeking_type', '=', 'mid_level_management', $conjunction);
                            break;
                        case 'executive':
                            $query = $query->where('contact.job_seeking_type', '=', 'executive', $conjunction);
                            break;
                        case 'all':
                        default:
                            break;
                    }
                    break;
                case 'job_seeking_status':
                    switch ($search_value) {
                        case 'unemployed':
                            $query = $query->where('contact.job_seeking_status', '=', 'unemployed', $conjunction);
                            break;
                        case 'employed_active':
                            $query = $query->where('contact.job_seeking_status', '=', 'employed_active', $conjunction);
                            break;
                        case 'employed_passive':
                            $query = $query->where('contact.job_seeking_status', '=', 'employed_passive', $conjunction);
                            break;
                        case 'employed_future':
                            $query = $query->where('contact.job_seeking_status', '=', 'employed_future', $conjunction);
                            break;
                        case 'employed_not':
                            $query = $query->where('contact.job_seeking_status', '=', 'employed_not', $conjunction);
                            break;
                        case 'all':
                        default:
                            break;
                    }
                    break;
                case Search::GROUP_LABEL:
                    if ($conjunction === "and") {
                        $query = $query->where(function($query) use ($search) {
                            return self::buildWhere($query, $search);
                        });
                    } else if ($conjunction === "or") {
                        $query = $query->orWhere(function($query) use ($search) {
                            return self::buildWhere($query, $search);
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
