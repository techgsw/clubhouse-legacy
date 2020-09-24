<?php

namespace App\Http\Controllers;

use App\Contact;
use App\League;
use App\Mentor;
use App\MentorRequest;
use App\MentorSocialMediaLink;
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
        if (!$request->session()->get('mentor_seed')) {
            $request->session()->put('mentor_seed', rand());
        }

        $is_blocked = !Auth::user() || MentorRequest::where('created_at', '>', (new \DateTime())->sub(new \DateInterval('P7D')))
            ->where('user_id', Auth::user()->id)
            ->count() > 1;

        $mentors = Mentor::with('contact')
            ->with('socialMediaLinks')
            ->where('active', true)
            ->search($request)
            ->select('contact.*', 'mentor.*')
            ->inRandomOrder($request->session()->get('mentor_seed'))
            ->paginate(15);

        $tags = Tag::has('mentors')->get();
        $leagues = League::has('organizations.contacts.mentor')->select('league.abbreviation')->get();

        return view('mentor/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Mentors' => "/mentor"
            ],
            'mentors' => $mentors,
            'tags' => $tags,
            'leagues' => $leagues,

            'tag' => $request->tag,
            'league' => $request->league,
            'is_blocked' => $is_blocked
        ]);
    }

    public function show(Request $request, $id)
    {
        $mentor = Mentor::with('contact')->with('socialMediaLinks')->find($id);

        if (!$mentor) {
            return abort(404);
        }

        $is_blocked = !Auth::user() || MentorRequest::where('created_at', '>', (new \DateTime())->sub(new \DateInterval('P7D')))
            ->where('user_id', Auth::user()->id)
            ->count() > 1;

        return view('mentor/show', [
            'mentor' => $mentor,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Mentors' => '/mentor',
                $mentor->contact->getName() => '/mentor/{{$id}}/show'
            ],
            'is_blocked' => $is_blocked
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

        if (request('linkedin_link')) {
            $linkedin_link = request('linkedin_link');
            Log::info($linkedin_link);
            Log::info(substr($linkedin_link, 0 , 18));
            if (
                substr($linkedin_link, 0 , 18) !== "https://www.linked"
                && substr($linkedin_link, 0, 14) !== "https://linked"
            ) {
                $request->flash();
                $request->session()->flash('message', new Message(
                    "Your LinkedIn link is not correctly formatted. Please make sure it starts with https://www.linkedin.com or https://linkedin.com",
                    "danger"
                ));
                return redirect()->back();
            }
            $mentor_linkedin_link = null;
            foreach($mentor->socialMediaLinks as $link) {
                if ($link->social_media_type == 'linkedin') {
                    $mentor_linkedin_link = $link;
                    $mentor_linkedin_link->link = $linkedin_link;
                    $mentor_linkedin_link->save();
                }
            }
            if (is_null($mentor_linkedin_link)) {
                MentorSocialMediaLink::create([
                    'mentor_id' => $id,
                    'social_media_type' => 'linkedin',
                    'link' => $linkedin_link
                ]);
            }
        } else {
            foreach($mentor->socialMediaLinks as $link) {
                if ($link->social_media_type == 'linkedin') {
                    $link->delete();
                }
            }
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
        $mentor->calendly_link = request('calendly_link') ?: "";
        $mentor->save();

        return redirect()->action('MentorController@edit', [$mentor->contact_id]);
    }

    public function request(Request $request, $id)
    {
        //$this->authorize('view-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return response()->json([
                'error' => 'Please confirm dates are valid and try again',
                'success' => null
            ]);
        }

        // GET request means calend.ly request. We don't need to check extra info
        if ($request->isMethod('post')) {
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
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'Sorry, there was an issue sending your mentor request. Please try again or contact clubhouse@sportsbusiness.solutions for support.',
                    'success' => null
                ]);
            }
        }

        try {
            MentorRequest::create([
                'user_id' => Auth::user()->id,
                'mentor_id' => $id
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $is_blocked = MentorRequest::where('created_at', '>', (new \DateTime())->sub(new \DateInterval('P7D')))
            ->where('user_id', Auth::user()->id)
            ->count() > 1;

        return response()->json([
            'error' => null,
            'success' => "Meeting requested. Check your email for details.",
            'is_blocked' => $is_blocked
        ]);
    }

}
