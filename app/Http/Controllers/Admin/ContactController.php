<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-contact');


    /*
        $filename = ROOT_DIR. "/public_html/files/fb/products.csv";

        $file_write = fopen($filename, 'w');

        fputcsv($file_write, $titles_row);

        $row = array($pv_id,$title,$description,$availability,$condition,$price,$url,$image,$brand,null,null,null,null,null,$google_product_category,null,null,$product_type,null,$sale_price_effecitve_date,null,null,null,$auction_type_code,$reserve_status,$consignor_id,$create_user_id,$filter_description);

        fputcsv($file_write, $row);
        fclose($file_write);

    */


        $contacts = Contact::search($request);
        $now = new \DateTime('NOW');
        $storage_path = storage_path().'/app/public/contacts/';
        $filename = $storage_path. "contacts_". $now->format('m-d-Y') .".csv";
        $file_write = fopen($filename, 'w');

        $column_titles = array_keys((new \App\Contact())->getAttributes());
        
        fputcsv($file_write, $column_titles);

        foreach($contacts->get() as $contact) {
            $row = array();
            foreach($contact->getAttributes() as $attribute => $value) {
                $row[] = $value;
            }
            fputcsv($file_write, $row);
        }

        fclose($file_write);

        //$headers = array(
        //    'Content-Type' => 'text/csv',
        //);

        //return Response::download($filename, $filename, $headers);
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
