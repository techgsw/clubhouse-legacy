<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-mentor');

        $mentors = Mentor::with('contact')->paginate(12);

        return view('mentor/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor"
            ],
            'mentors' => $mentors
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

        return view('contact/mentor', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor",
                "{$contact->getName()}" => "/contact/{$contact->id}/mentor"
            ],
            'contact' => $contact
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return abort(404);
        }

        $mentor->description = request('description');
        $mentor->active = request('active');
        $mentor->save();

        return redirect()->action('MentorController@edit', [$mentor->contact_id]);
    }
}
