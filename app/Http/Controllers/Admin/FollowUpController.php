<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('follow-up');

        //TODO: Refactor Bob's id to global constant
        if (Auth::user()->id == 1) {
            $contacts = Contact::where('follow_up_user_id', '!=', null)->orderBy('follow_up_date', 'asc');
        } else {
            $contacts = Contact::where('follow_up_user_id', Auth::user()->id)->orderBy('follow_up_date', 'asc');
        }
        $count = $contacts->count();
        $contacts = $contacts->paginate(15);

        return view('admin/follow-up', [
            'contacts' => $contacts,
            'count' => $count
        ]);
    }
}
