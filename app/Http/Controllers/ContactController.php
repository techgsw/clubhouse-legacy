<?php

namespace App\Http\Controllers;

use App\Contact;
use App\ContactRelationship;
use App\Note;
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
        $contact = Contact::find($id);
        if (!$contact) {
            return abort(404);
        }
        // TODO $this->authorize('view-contact', $contact);
        $notes = Note::contact($id);

        return view('contact/show', [
            'contact' => $contact,
            'notes' => $notes,
            'breadcrumb' => [
                'Home' => '/',
                'Contact' => '/contact/'.$contact->id,
                $contact->getName() ?: $contact->getOrganization() => "/contact/$id",
            ]
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return abort(404);
        }
        // TODO $this->authorize('edit-contact', $contact);

        // TODO see ProfileController.update

        return redirect()->action('ContactController@show', [$contact]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showNotes($id)
    {
        // TODO port from ProfileController.showNotes, which will be deprecated
        $this->authorize('view-profile-notes');

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
        // TODO port from ProfileController.createNotes, which will be deprecated
        $this->authorize('create-profile-note');

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
    public function referContact(Request $request)
    {
        //TODO: Add contact relationship creating resource
        //$this->authorize('refer-contact');
        $this->authorize('create-profile-note');

        $user_id = $request->user_id;
        $contact_id = $request->contact_id;

        try {
            $user = ContactRelationship::create([
                'contact_id' => $contact_id,
                'user_id' => $user_id,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($e->getCode() === '23000') {
                $message = "Oops! That relationship already exists.";
            } else {
                $message = "Sorry, we were unable to create that relationship. Please contact support.";
            }
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
        //TODO: Add contact relationship editing resource
        //$this->authorize('edit-contact-relationship');
        $this->authorize('create-profile-note');

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
