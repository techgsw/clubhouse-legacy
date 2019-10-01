<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InvalidSearchException;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Message;
use App\Providers\SearchServiceProvider;
use App\Search;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $contacts = $this->searchForContacts($request);
        if ($contacts instanceof RedirectResponse) {
            return $contacts;
        }
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
        $contacts = $this->searchForContacts($request);
        if ($contacts instanceof RedirectResponse) {
            return $contacts;
        }
        $contacts = $contacts->with('user')->get();

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
            'organization',
            'contact_created',
            'account_created',
            'last_login'
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
                    if($attribute == 'contact_created') {
                        $row[] = $contact->created_at;
                    } else if ($contact->user && $attribute == 'account_created') {
                        $row[] = $contact->user->created_at;
                    } else if ($contact->user && $attribute == 'last_login') {
                        $row[] = $contact->user->last_login_at;
                    } else {
                        $row[] = $contact->$attribute;
                    }
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }

    private function searchForContacts(Request $request) {
        try {
            $searches = SearchServiceProvider::parseSearchString($request->query->get('search'));
            $job_seeking_type = $request->query->get('job_seeking_type');
            if ($job_seeking_type !== null) {
                array_push($searches, new Search("and", "job_seeking_type", $job_seeking_type));
            }
            $job_seeking_status = $request->query->get('job_seeking_status');
            if ($job_seeking_status !== null) {
                array_push($searches, new Search("and", "job_seeking_status", $job_seeking_status));
            }
            return Contact::search($request->query->get('sort'), $searches);
        } catch (InvalidSearchException $e) {
            $request->session()->flash('message', new Message(
                $e->getMessage(),
                "danger",
                $e->getCode(),
                "error"
            ));
            return redirect()->back();
        }
    }
}
