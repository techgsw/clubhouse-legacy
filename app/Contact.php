<?php

namespace App;

use App\Note;
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

        // $sort = $request->query->get('sort');
        // switch ($sort) {
        // case 'id-desc':
        //     $users = $users->orderBy('user.id', 'desc');
        //     break;
        // case 'id-asc':
        //     $users = $users->orderBy('user.id', 'asc');
        //     break;
        // case 'email-desc':
        //     $users = $users->orderBy('user.email', 'desc');
        //     break;
        // case 'email-asc':
        //     $users = $users->orderBy('user.email', 'asc');
        //     break;
        // case 'name-desc':
        //     $users = $users->orderBy('user.last_name', 'desc');
        //     break;
        // case 'name-asc':
        //     $users = $users->orderBy('user.last_name', 'asc');
        //     break;
        // default:
        //     $users = $users->orderBy('user.id', 'desc');
        //     break;
        // }

        return $contacts;
    }
}
