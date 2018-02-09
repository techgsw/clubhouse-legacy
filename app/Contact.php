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
