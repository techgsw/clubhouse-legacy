<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-contact');

        $contacts = Contact::search($request);
        $storage_path = storage_path().'/contacts/';
        echo $storage_path;
        $filename = Auth::user()->first_name ."_contacts.csv";
        $file_path = $storage_path . $filename;
        $file_write = fopen($file_path, 'w');

        $contacts = $contacts->get();
        //$column_titles = array_keys((new \App\Contact())->getAttributes());
        $column_titles = array_keys($contacts[0]->getAttributes());
        
        fputcsv($file_write, $column_titles);

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
                }
                $row[] = $value;
            }
            fputcsv($file_write, $row);
        }

        fclose($file_write);

        $headers = array(
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.basename($file_path).'"',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
            'Content-Length' => filesize($file_path)
        );
        return $request->download($file_path, $filename, $headers);
        //readfile($filename);
        //return $this->download($request, $filename);
        //$contacts = Contact::search($request);
        //$count = $contacts->count();
        //$contacts = $contacts->paginate(15);

        //return view('admin/contact', [
        //    'contacts' => $contacts,
        //    'count' => $count
        //]);
    }

    /**
     * @return \Illuminate\Http\Response Download File
     */
    public function download(Request $request)
    {
        $this->authorize('create-contact');
        $contacts = Contact::search($request);
        $now = new \DateTime('NOW');
        $filename = "contacts_". $now->format('m-d-Y') .".csv";
        $handle = fopen($filename, 'w');

        $column_titles = $contacts->first()->getAttributes();
        
        fputcsv($handle, $column_titles);

        foreach($contacts as $contact) {
            $row = array();
            foreach($contact->getAttributes() as $attribute => $value) {
                $row[] = $value;
            }
            fputcsv($handle, $row);
        }

        fclose($handle);

        //$headers = array(
        //    'Content-Type' => 'text/csv',
        //);

        //return Response::download($handle, 'tweets.csv', $headers);
/*
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
*/
    }
}
