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
        $this->authorize('view-contact');
        $contacts = Contact::search($request);
        $contacts = $contacts->get();

        if (count($contacts) < 1) {
            $request->session()->flash('message', new Message(
                "Unable to find any contacts that match those search parameters.",
                "warning",
                $code = null,
                $icon = "account_circle"
            ));
            return redirect()->back();
        }

        $now = new \DateTime("NOW");
        $column_titles = [
            'first_name',
            'last_name',
            'email',
            'title',
            'organization'
        ];
        $filename = "contacts-".$now->format("Y-m-d").".csv";

        $headers = array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        );

        return new StreamedResponse(function() use($contacts, $column_titles){
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $column_titles);
            foreach ($contacts as $contact) {
                $row = array();
                foreach($column_titles as $attribute) {
                    $row[] = $contact->$attribute;
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
