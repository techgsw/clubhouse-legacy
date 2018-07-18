<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mentor;
use App\Message;
use App\Tag;
use App\User;
use App\Mail\MentorshipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-mentor');

        $mentors = Mentor::with('contact')
            ->search($request)
            ->select('contact.*', 'mentor.*')
            ->paginate(12);

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

    public function request(Request $request, $id)
    {
        $this->authorize('view-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return response()->json([
                'error' => 'Please confirm dates are valid and try again',
                'success' => null
            ]);
        }

        $now = new \DateTime('NOW');
        try {
            $date1 = new \DateTime($request->date_1);
            $date1->setTime(substr($request->time_1, 0, 2), substr($request->time_1, 2, 2));

            $date2 = new \DateTime($request->date_2);
            $date2->setTime(substr($request->time_2, 0, 2), substr($request->time_2, 2, 2));

            $date3 = new \DateTime($request->date_3);
            $date3->setTime(substr($request->time_3, 0, 2), substr($request->time_3, 2, 2));

            if ($date1 < $now || $date2 < $now || $date3 < $now) {
                throw new \Exception("At least one date is invalid");
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Please confirm dates are valid and try again',
                'success' => null
            ]);
        }

        try {
            // Confirm request with user
            Mail::to(Auth::user())->send(new MentorshipRequest(
                $mentor,
                Auth::user(),
                $dates = [$date1, $date2, $date3]
            ));

            // Alert Bob about request
            $bob = User::where('id', 1)->first();
            Mail::to($bob)->send(new \App\Mail\Admin\MentorshipRequest(
                $mentor,
                Auth::user(),
                $dates = [$date1, $date2, $date3]
            ));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return response()->json([
            'error' => null,
            'success' => "Meeting requested. Check your email for details."
        ]);
    }
}
