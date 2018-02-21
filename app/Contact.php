<?php

namespace App;

use App\Note;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    protected $table = 'contact';
    protected $guarded = [];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsToMany(Address::class);
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
            && $this->phone === $profile->user->phone
            // Profile
            && $this->organization === $profile->organization
            && $this->title === $profile->user->title
            && $this->job_seeking_status === $profile->user->job_seeking_status
            && $this->job_seeking_type === $profile->user->job_seeking_type
            // Address
            && $this->address[0]->line1 === $profile->address[0]->line1
            && $this->address[0]->line2 === $profile->address[0]->line2
            && $this->address[0]->city === $profile->address[0]->city
            && $this->address[0]->state === $profile->address[0]->state
            && $this->address[0]->postal_code === $profile->address[0]->postal_code
            && $this->address[0]->country === $profile->address[0]->country;
    }

    public static function search(Request $request)
    {
        $contacts = Contact::where('id', '>', 0);

        $term = $request->query->get('term');

        $index = $request->query->get('index') ?: 'name';
        switch ($index) {
        case 'id':
            $term = (int)$term;
            $contacts = $contacts->where('contact.id', $term);
            break;
        case 'organization':
            $contacts = $contacts->where('contact.organization', 'like', "%$term%");
            break;
        case 'title':
            $contacts = $contacts->where('contact.title', 'like', "%$term%");
            break;
        case 'email':
            $contacts = $contacts->where('contact.email', 'like', "%$term%");
            break;
        case 'name':
        default:
            $contacts = $contacts->where(DB::raw('CONCAT(contact.first_name, " ", contact.last_name)'), 'like', "%$term%");
        }

        $sort = $request->query->get('sort');
        switch ($sort) {
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

        $job_seeking_type = $request->query->get('job_seeking_type');
        switch ($job_seeking_type) {
        case 'internship':
            $contacts = $contacts->where('contact.job_seeking_type', 'internship');
            break;
        case 'entry_level':
            $contacts = $contacts->where('contact.job_seeking_type', 'entry_level');
            break;
        case 'mid_level':
            $contacts = $contacts->where('contact.job_seeking_type', 'mid_level');
            break;
        case 'entry_level_management':
            $contacts = $contacts->where('contact.job_seeking_type', 'entry_level_management');
            break;
        case 'mid_level_management':
            $contacts = $contacts->where('contact.job_seeking_type', 'mid_level_management');
            break;
        case 'executive':
            $contacts = $contacts->where('contact.job_seeking_type', 'executive');
            break;
        case 'all':
        default:
            break;
        }

        $job_seeking_status = $request->query->get('job_seeking_status');
        switch ($job_seeking_status) {
        case 'unemployed':
            $contacts = $contacts->where('contact.job_seeking_status', 'unemployed');
            break;
        case 'employed_active':
            $contacts = $contacts->where('contact.job_seeking_status', 'employed_active');
            break;
        case 'employed_passive':
            $contacts = $contacts->where('contact.job_seeking_status', 'employed_passive');
            break;
        case 'employed_future':
            $contacts = $contacts->where('contact.job_seeking_status', 'employed_future');
            break;
        case 'employed_not':
            $contacts = $contacts->where('contact.job_seeking_status', 'employed_not');
            break;
        case 'all':
        default:
            break;
        }

        return $contacts;
    }
}
