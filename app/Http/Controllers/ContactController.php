<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressContact;
use App\Contact;
use App\ContactRelationship;
use App\Note;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $contact = Contact::with('address')->find($id);
        if (!$contact) {
            return abort(404);
        }
        $this->authorize('view-contact', $contact);

        $notes = Note::contact($id);

        if ($contact->phone && strlen($contact->phone) == 10) {
            $contact->phone = "(".substr($contact->phone, 0, 3).")".substr($contact->phone, 3, 3)."-".substr($contact->phone, 6, 4);
        }
        if ($contact->user && $contact->user->profile->phone && strlen($contact->user->profile->phone) == 10) {
            $contact->user->profile->phone = "(".substr($contact->user->profile->phone, 0, 3).")".substr($contact->user->profile->phone, 3, 3)."-".substr($contact->user->profile->phone, 6, 4);
        }

        return view('contact/show', [
            'contact' => $contact,
            'notes' => $notes,
            'breadcrumb' => [
                'Home' => '/',
                'Contacts' => '/admin/contact',
                $contact->getName() ?: $contact->getOrganization() => "/contact/$id",
            ]
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

        // TODO Check by email if the Contact already exists
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

        try {
            $resume = request()->file('resume');
            if ($resume) {
                $d = $resume->store('resume', 'public');
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

        $contact = Contact::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone' => request('phone'),
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

        return redirect()->action('ContactController@show', [$contact]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return abort(404);
        }
        $this->authorize('edit-contact', $contact);

        $address = $contact->address[0];
        if (!$address) {
            return abort(404);
        }

        // Contact
        $contact->first_name = request('first_name');
        $contact->last_name = request('last_name');
        $contact->phone = request('phone')
            ? preg_replace("/[^\d]/", "", request('phone'))
            : null;
        // TODO 101 allow this?
        // $contact->email = request('email');
        $contact->title = request('title');
        $contact->organization = request('organization');
        $contact->job_seeking_type = request('job_seeking_type');
        $contact->job_seeking_status = request('job_seeking_status');
        $contact->updated_at = new \DateTime('NOW');
        $contact->save();

        // Address
        $address->line1 = request('line1');
        $address->line2 = request('line2');
        $address->city = request('city');
        $address->state = request('state');
        $address->postal_code = request('postal_code');
        $address->country = request('country');
        $address->updated_at = new \DateTime('NOW');
        $address->save();

        return redirect()->action('ContactController@show', [$contact]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showNotes($id)
    {
        $this->authorize('view-contact-notes');

        $notes = Note::contact($id);

        return view('contact/notes/show', [
            'notes' => $notes
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNote($id)
    {
        $this->authorize('create-contact-note');

        $contact = Contact::find($id);
        if (!$contact) {
            return abort(404);
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->notable_id = $id;
        $note->notable_type = "App\Contact";
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

}
