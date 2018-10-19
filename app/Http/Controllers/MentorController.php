<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mentor;
use App\Message;
use App\Tag;
use App\User;
use App\Providers\EmailServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $mentors = Mentor::with('contact')
            ->where('active', true)
            ->search($request)
            ->select('contact.*', 'mentor.*')
            ->paginate(12);

        $tags = Tag::has('mentors')->get();

        return view('mentor/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Mentors' => "/mentor"
            ],
            'mentors' => $mentors,
            'tags' => $tags
        ]);
    }

    public function show(Request $request, $id)
    {
        $mentor = Mentor::with('contact')->find($id);

        if (!$mentor) {
            return abort(404);
        }

        return view('mentor/show', [
            'mentor' => $mentor,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Mentors' => '/mentor',
                $mentor->contact->getName() => '/mentor/{{$id}}/show'
            ]
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
                'Clubhouse' => '/',
                'Sports Industry Mentors' => "/mentor",
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
        $mentor->timezone = request('timezone') ?: "";
        $mentor->day_preference_1 = request('day_preference_1') ?: "";
        $mentor->time_preference_1 = request('time_preference_1') ?: "";
        $mentor->day_preference_2 = request('day_preference_2') ?: "";
        $mentor->time_preference_2 = request('time_preference_2') ?: "";
        $mentor->day_preference_3 = request('day_preference_3') ?: "";
        $mentor->time_preference_3 = request('time_preference_3') ?: "";
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

        if (!$mentor->active) {
            return response()->json([
                'error' => 'Sorry, that mentor is not available right now',
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
            EmailServiceProvider::sendMentorshipRequestEmails(
                Auth::user(),
                $mentor,
                $dates = [$date1, $date2, $date3]
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return response()->json([
            'error' => null,
            'success' => "Meeting requested. Check your email for details."
        ]);
    }
}
