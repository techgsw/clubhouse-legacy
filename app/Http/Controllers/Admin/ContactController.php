<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contact;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-contact');
        $contacts = Contact::search($request);
        $count = $contacts->count();
        $contacts = $contacts->paginate(15);

        return view('admin/contact', [
            'contacts' => $contacts,
            'count' => $count
        ]);
    }

    /**
     * @return \Illuminate\Http\Response Download File
     */
    public function download(Request $request)
    {
        $this->authorize('create-contact');
        $contacts = Contact::search($request);
        $contacts = $contacts->get();

        if (count($contacts) < 1) {
            $request->session()->flash('message', new Message(
                "Unable to find any contacts that match those search parameters.",
                "warning",
                $code = null,
                $icon = "account_circle"
            )); 
            return redirect()->action('Admin\ContactController@index');
        }

        $column_titles = array_keys($contacts[0]->getAttributes());
        $filename = Auth::user()->first_name ."_contacts.csv";

        $headers = array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        );

        return new StreamedResponse(function() use($contacts, $column_titles){
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $column_titles);
            foreach($contacts as $contact) {
                $row = array();
                foreach($contact->getAttributes() as $attribute => $value) {
                    switch ($attribute) {
                        case 'resume_url':
                            if (is_null($value)) {
                                $value = 'No';
                            } else {
                                $value = 'Yes';
                            }
                            break;
                        case 'user_id':
                            if (is_null($value)) {
                                $value = 'No';
                            } else {
                                $value = 'Yes';
                            }
                            break;
                    }
                    $row[] = $value;
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
