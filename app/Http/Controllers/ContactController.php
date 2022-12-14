<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressContact;
use App\Contact;
use App\ContactRelationship;
use App\JobTagWhiteList;
use App\Mentor;
use App\Message;
use App\Note;
use App\Organization;
use App\JobPipeline;
use App\TagType;
use App\Http\Requests\CreateNote;
use App\Http\Requests\CloseFollowUp;
use App\Http\Requests\RescheduleFollowUp;
use App\Http\Requests\ScheduleFollowUp;
use App\Providers\ImageServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use \Exception;

class ContactController extends Controller
{
    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        foreach(auth()->user()->roles as $role){
            if ($role->code == 'admin' || $role->code == 'superuser'){
                $this->authorize('edit-roles', Auth::User());
            }
        }
        $contact = Contact::with('address')->find($id);
        if (!$contact) {
            return abort(404);
        }
        $this->authorize('view-contact', $contact);

        $notes = Note::contact($id);

        // Format phone numbers
        if ($contact->phone && strlen($contact->phone) == 10) {
            $contact->phone = "(".substr($contact->phone, 0, 3).")".substr($contact->phone, 3, 3)."-".substr($contact->phone, 6, 4);
        }
        if ($contact->secondary_phone && strlen($contact->secondary_phone) == 10) {
            $contact->secondary_phone = "(".substr($contact->secondary_phone, 0, 3).")".substr($contact->secondary_phone, 3, 3)."-".substr($contact->secondary_phone, 6, 4);
        }
        if ($contact->user) {
            if ($contact->user->profile->phone && strlen($contact->user->profile->phone) == 10) {
                $contact->user->profile->phone = "(" . substr($contact->user->profile->phone, 0, 3) . ")" . substr($contact->user->profile->phone, 3, 3) . "-" . substr($contact->user->profile->phone, 6, 4);
            }
            if ($contact->user->profile->secondary_phone && strlen($contact->user->profile->secondary_phone) == 10) {
                $contact->user->profile->secondary_phone = "(".substr($contact->user->profile->secondary_phone, 0, 3).")".substr($contact->user->profile->secondary_phone, 3, 3)."-".substr($contact->user->profile->secondary_phone, 6, 4);
            }
        }

        $breadcrumb = array(
            'Home' => '/',
            'Contacts' => '/admin/contact',
            $contact->getName() ?: $contact->getOrganization() => "/contact/$id"
        );

        if (!Gate::allows('view-admin-dashboard')) {
            // Only admins should have contact search added to the breadcrumb
            unset($breadcrumb['Contacts']);
        }

        $redirect_url = null;
        if (strpos(url()->previous(), '/admin/contact')) {
            $redirect_url = url()->previous();
        }

        $whiteList = JobTagWhiteList::all()
            ->pluck('tag_name')
            ->toArray();
        $job_tags = TagType::where('type', 'job')
            ->whereIn('tag_name', $whiteList)
            ->orderBy('tag_name')
            ->get();

        return view('contact/show', [
            'contact' => $contact,
            'notes' => $notes,
            'breadcrumb' => $breadcrumb,
            'redirect_url' => $redirect_url,
            'job_tags' => $job_tags
        ]);
    }

    public function jobs(Request $request, $id)
    {
        $contact = Contact::find($id);

        $job_pipeline = JobPipeline::all();

        if (!$contact) {
            return abort(404);
        }
        $this->authorize('view-contact', $contact);

        $breadcrumb = array(
            'Home' => '/',
            'Contacts' => '/admin/contact',
            'Jobs' => "/contact/{$contact->id}/jobs"
        );

        if (!Gate::allows('view-admin-dashboard')) {
            // Only admins should have contact search added to the breadcrumb
            unset($breadcrumb['Contacts']);
        }

        return view('contact/jobs', [
            'breadcrumb' => $breadcrumb,
            'contact' => $contact,
            'job_pipeline' => $job_pipeline
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-contact');

        return view('contact/create', [
            'breadcrumb' => [
                'Home' => '/',
                'Contacts' => '/admin/contact',
                'New' => "/contact/create"
            ]
        ]);
    }

    /**
     * @param  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // TODO StoreContact request for validation

        $contact = Contact::where('email', $email = $request->email)->get();
        if (count($contact) > 0) {
            $request->session()->flash('message', new Message(
                "Contact with email address {$email} already exists.",
                "warning",
                $code = null,
                $icon = "account_circle"
            ));
            return redirect()->action('ContactController@show', [$contact[0]]);
        }

        $contact = DB::transaction(function() use($request) {
            $resume = null;
            if ($request->hasFile('resume')) {
                try {
                    $resume = request()->file('resume');
                    if ($resume) {
                        $resume = $resume->store('resume', 'public');
                    }
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    $request->session()->flash('message', new Message(
                        "Sorry, the resume you tried to upload failed.",
                        "danger",
                        $code = null,
                        $icon = "error"
                    ));
                    return back()->withInput();
                }
            }

            $contact = Contact::create([
                'first_name' => request('first_name'),
                'last_name' => request('last_name'),
                'email' => request('email'),
                'secondary_email' => request('secondary_email'),
                'phone' => request('phone'),
                'secondary_phone' => request('secondary_phone'),
                'title' => request('title'),
                'organization' => request('organization'),
                'job_seeking_status' => request('job_seeking_status'),
                'job_seeking_type' => request('job_seeking_type'),
                'resume_url' => $resume,
            ]);

            $address = Address::create([
                'line1' => request('line1'),
                'line2' => request('line2'),
                'city' => request('city'),
                'state' => request('state'),
                'postal_code' => request('postal_code'),
                'country' => request('country')
            ]);

            $address_contact = AddressContact::create([
                'address_id' => $address->id,
                'contact_id' => $contact->id
            ]);

            if (request('note')) {
                $note = new Note();
                $note->user_id = Auth::user()->id;
                $note->notable_id = $contact->id;
                $note->notable_type = "App\Contact";
                $note->content = request("note");
                $note->save();
            }

            return $contact;
        });

        if (!$contact) {
            return redirect()->back()->withErrors([
                'msg' => 'Failed to save contact. Please try again.'
            ]);
        }

        return redirect()->action('ContactController@show', [$contact]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return abort(404);
        }
        $this->authorize('edit-contact', $contact);

        $image_error = false;

        try {
            DB::transaction(function () use ($request, $contact) {
                if ($headshot = request()->file('headshot_url')) {
                    $image = ImageServiceProvider::saveFileAsImage(
                        $headshot,
                        $filename = preg_replace('/\s/', '-', str_replace("/", "", $contact->first_name.'-'.$contact->last_name)).'-SportsBusinessSolutions',
                        $directory = 'contact/'.$contact->id,
                        $options = [
                            'cropFromCenter' => true,
                            'update' => $contact->headshotImage ?: null
                        ]
                    );

                    $contact->headshot_image_id = $image->id;
                    $contact->save();
                }
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $image_error = true;
        }

        // Only allow users to change email to one that is not being used by another user
        $email = request('email');
        if ($email != $contact->email) {
            $existing_contact_email = Contact::where('email', $email)->get();
            if ($existing_contact_email->count() > 0) {
                $request->session()->flash('message', new Message(
                            "Sorry, that email is already taken.",
                            "danger",
                            $code = null,
                            $icon = "error"
                            ));
                return back()->withInput();
            }
        }

        if (!$contact->address[0]) {
            return abort(404);
        }
        // Contact
        $resume = null;
        if ($request->hasFile('resume')) {
            try {
                $resume = request()->file('resume');
                if ($resume) {
                    $resume = $resume->store('resume', 'public');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                $request->session()->flash('message', new Message(
                    "Sorry, the resume you tried to upload failed.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
        }

        $contact = DB::transaction(function () use ($request, $contact, $resume) {
            $contact->email = request('email');
            $contact->secondary_email = request('secondary_email');
            $contact->first_name = request('first_name');
            $contact->last_name = request('last_name');
            $contact->phone = request('phone')
                ? preg_replace("/[^\d]/", "", request('phone'))
                : null;
            $contact->secondary_phone = request('secondary_phone')
                ? preg_replace("/[^\d]/", "", request('secondary_phone'))
                : null;
            $contact->gender = request('gender');
            $contact->ethnicity = request('ethnicity');

            $contact->title = request('title');
            // ContactOrganization relationship
            $current_org = $contact->organizations->first();
            $new_org = Organization::where('name', request('organization'))->first();
            if (!empty($new_org) && (empty($current_org) || $current_org->id != $new_org->id)) {
                $contact->organizations()->attach($new_org->id);
                if (!empty($current_org)) {
                    $contact->organizations()->detach($current_org->id);
                }
            } elseif ($contact->organization == request('organization')) {
                // No change, no action
            } elseif (!empty($current_org)) {
                $contact->organizations()->detach($current_org->id);
            }
            $contact->organization = request('organization');
            $contact->job_seeking_type = request('job_seeking_type');
            $contact->job_seeking_status = request('job_seeking_status');
            $contact->job_seeking_region = request('job_seeking_region');
            if (!is_null($resume)) {
                $contact->resume_url = $resume;
            }
            $contact->updated_at = new \DateTime('NOW');
            $contact->save();

            // Address
            $address = $contact->address[0];
            $address->line1 = request('line1');
            $address->line2 = request('line2');
            $address->city = request('city');
            $address->state = request('state');
            $address->postal_code = request('postal_code');
            $address->country = request('country');
            $address->updated_at = new \DateTime('NOW');
            $address->save();

            // Mentor
            if (request('mentor') == "1") {
                if (is_null($contact->mentor)) {
                    // Create mentor
                    $mentor = new Mentor;
                    $mentor->contact_id = $contact->id;
                    $mentor->active = true;
                    $mentor->activated_at = new \DateTime('now');
                    $mentor->save();
                } elseif (!$contact->mentor->active) {
                    // Activate mentor
                    $contact->mentor->active = true;
                    $contact->mentor->activated_at = new \DateTime('now');
                    $contact->mentor->save();
                }
            } else if (!is_null($contact->mentor)) {
                // Deactivate mentor
                $contact->mentor->active = false;
                $contact->mentor->save();
            }

            // Job discipline preferences
            $email_preference_tag_type_ids = array();
            foreach($request->all() as $key=>$datum) {
                if (strpos($key, 'email_preference_job_') !== false && $datum) {
                    try {
                        $tag_type_id = intval(explode('email_preference_job_', $key)[1]);
                        if (TagType::find($tag_type_id) !== null) {
                            $email_preference_tag_type_ids[] = $tag_type_id;
                        }
                    } catch (\Throwable $t) {
                        Log::error($t);
                    }
                }
            }
            $contact->emailPreferenceTagTypes()->sync($email_preference_tag_type_ids);

            return $contact;
        });

        if ($image_error) {
            $request->session()->flash('message', new Message(
                "Sorry, the image failed to upload. Please try a different image.",
                "danger",
                $code = null,
                $icon = "error"
            ));
        } else {
            $current_org = $contact->organizations->first();
            if (!is_null($current_org)) {
                $contact->organizations()->detach($current_org->id);
            }
        }
        $contact->organization = request('organization');
        $contact->job_seeking_type = request('job_seeking_type');
        $contact->job_seeking_status = request('job_seeking_status');

        $request->session()->flash('message', new Message(
            "Contact saved",
            "success",
            $code = null,
            $icon = "check_circle"
        ));

        return redirect()->action('ContactController@show', [$contact]);
    }

    public function showNoteControl($id)
    {
        $this->authorize('view-contact-notes');

        $notes = Note::contact($id);
        $contact = Contact::find($id);

        return view('contact/notes/control', [
            'contact' => $contact,
            'notes' => $notes
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNote(CreateNote $request)
    {
        $this->authorize('create-contact-note');

        $notable = explode('-', request('notable_id'));
        $contact = Contact::find(request('contact_id'));
        if (!$contact) {
            return abort(404);
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;

        if ($notable[0] == 'inquiry') {
            $note->notable_type = "App\Inquiry";
            $note->notable_id = $notable[1];
        } else if ($notable[0] == 'contact_job') {
            $note->notable_type = "App\ContactJob";
            $note->notable_id = $notable[1];
        } else {
            $note->notable_id = $contact->id;
            $note->notable_type = "App\Contact";
        }
        $note->content = request("note");
        $note->save();

        return response()->json([
            'type' => 'success',
            'content' => $note->content,
            'user' => Auth::user()
        ]);
    }

    /**
     * @param  int  $user_id
     * @param  int  $contact_id
     * @return \Illuminate\Http\Response
     */
    public function addRelationship(Request $request)
    {
        $this->authorize('add-contact-relationship');

        $user_id = $request->user_id;
        $contact_id = $request->contact_id;

        try {
            $user = ContactRelationship::create([
                'contact_id' => $contact_id,
                'user_id' => $user_id,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $message = "Sorry, we were unable to create that relationship. Please contact support.";
            $request->session()->flash('message', new Message(
                $message,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return response()->json([
                'error' => $message,
                'tag' => null
            ]);
        }

        return response()->json([
            'error' => null
        ]);
    }

    /**
     * @param  int  $user_id
     * @param  int  $contact_id
     * @return \Illuminate\Http\Response
     */
    public function removeRelationship(Request $request)
    {
        $this->authorize('remove-contact-relationship');

        $user_id = $request->user_id;
        $contact_id = $request->contact_id;

        try {
            $relationship = ContactRelationship::where('contact_id','=',$contact_id)
                ->where('user_id','=',$user_id);
            $relationship->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $message = "Sorry, we were unable to delete that relationship. Please contact support.";
            $request->session()->flash('message', new Message(
                $message,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return response()->json([
                'error' => $message,
                'tag' => null
            ]);
        }

        return response()->json([
            'error' => null
        ]);
    }

    /**
     * @param  ScheduleFollowUp  $request
     * @return Response
     */
    public function scheduleFollowUp(ScheduleFollowUp $request)
    {
        $contact_id = request('contact_id');
        $contact = Contact::find($contact_id);
        if (!$contact) {
            return abort(404);
        }

        try {
            $contact = DB::transaction(function() use($request, $contact) {
                $follow_up_date = request('follow_up_date');
                $follow_up_date = new \DateTime($follow_up_date);

                $contact->follow_up_date = $follow_up_date->format('Y-m-d 00:00:00');
                $contact->follow_up_user_id = Auth::user()->id;
                $contact->save();

                if (request('note')) {
                    $note = new Note();
                    $note->user_id = Auth::user()->id;
                    $inquiry_id = request('inquiry_id') ?: null;
                    if (is_null($inquiry_id)) {
                        $note->notable_id = request('contact_id');
                        $note->notable_type = "App\Contact";
                    } else {
                        $note->notable_id = $inquiry_id;
                        $note->notable_type = "App\Inquiry";
                    }
                    $note->content = request('note');
                    $note->content .= "\nFollow-up scheduled for {$contact->follow_up_date->format('d F, Y')}";
                    $note->save();
                }

                return $contact;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "error" => "Failed to schedule follow-up."
            ]);
        }

        return response()->json([
            "error" => null
        ]);
    }

    /**
     * @param  RescheduleFollowUp  $request
     * @return Response
     */
    public function rescheduleFollowUp(RescheduleFollowUp $request)
    {
        $contact_id = request('contact_id');
        $contact = Contact::find($contact_id);
        if (!$contact) {
            return abort(404);
        }

        try {
            $contact = DB::transaction(function() use($request, $contact) {
                $follow_up_date = request('follow_up_date');
                $follow_up_date = new \DateTime($follow_up_date);

                $contact->follow_up_date = $follow_up_date->format('Y-m-d 00:00:00');
                $contact->follow_up_user_id = Auth::user()->id;
                $contact->save();

                $note = new Note();
                $note->user_id = Auth::user()->id;
                $inquiry_id = request('inquiry_id') ?: null;
                if (is_null($inquiry_id)) {
                    $note->notable_id = request('contact_id');
                    $note->notable_type = "App\Contact";
                } else {
                    $note->notable_id = $inquiry_id;
                    $note->notable_type = "App\Inquiry";
                }
                $note->content = request('note');
                $note->content .= "\nFollow-up rescheduled for {$contact->follow_up_date->format('d F, Y')}";
                $note->save();

                return $contact;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "error" => "Failed to reschedule follow-up."
            ]);
        }

        return response()->json([
            "error" => null
        ]);
    }

    public function closeFollowUp(CloseFollowUp $request)
    {
        $contact_id = request('contact_id');
        $contact = Contact::find($contact_id);
        if (!$contact) {
            return abort(404);
        }

        try {
            $contact = DB::transaction(function() use($request, $contact) {
                $note = new Note();
                $note->user_id = Auth::user()->id;
                $inquiry_id = request('inquiry_id') ?: null;
                if (is_null($inquiry_id)) {
                    $note->notable_id = request('contact_id');
                    $note->notable_type = "App\Contact";
                } else {
                    $note->notable_id = $inquiry_id;
                    $note->notable_type = "App\Inquiry";
                }
                $note->content = request('note');
                $note->content .= "\nFollow-up closed";
                $note->save();

                $contact->follow_up_date = null;
                $contact->follow_up_user_id = null;
                $contact->save();
                return $contact;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "error" => "Failed to close follow-up."
            ]);
        }

        return response()->json([
            "error" => null
        ]);
    }
}
