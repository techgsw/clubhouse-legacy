<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mentor;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-mentor');

        $mentors = Mentor::with('contact')->paginate(12);
        $tags = Tag::has('mentors')->get();

        return view('mentor/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor"
            ],
            'mentors' => $mentors,
            'tags' => $tags
        ]);
    }

    public function show(Request $request, $id)
    {
        $mentor = Mentor::find($id);
        if (!$mentor) {
            return abort(404);
        }
        $this->authorize('view-mentor');

        return view('mentor/show', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor",
                "{$mentor->contact->getName()}" => "/mentor/{$mentor->id}"
            ],
            'mentor' => $mentor
        ]);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $contact = Contact::with('mentor')->find($id);
        if (!$contact || !$contact->mentor) {
            return abort(404);
        }

        $tags = [];
        foreach ($contact->mentor->tags as $tag) {
            $tags[] = $tag->name;
        }
        $mentor_tags_json = json_encode($tags);

        return view('contact/mentor', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor",
                "{$contact->getName()}" => "/contact/{$contact->id}/mentor"
            ],
            'contact' => $contact,
            'mentor_tags_json' => $mentor_tags_json
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return abort(404);
        }

        $tag_json = request('mentor_tags_json');
        $tag_names = json_decode($tag_json);
        $mentor->tags()->sync($tag_names);
        $mentor->description = request('description') ?: "";
        $mentor->active = request('active') === '1';
        $mentor->save();

        return redirect()->action('MentorController@edit', [$mentor->contact_id]);
    }
}
