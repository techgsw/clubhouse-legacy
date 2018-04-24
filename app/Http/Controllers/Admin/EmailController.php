<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('edit-email');

        // TODO Why doesn't this work?
        // https://laravel.com/docs/5.5/eloquent-relationships#eager-loading
        // $users = User::with(['roles' => function ($query) {
        //     $query->where('code', 'sbs');
        // }]);

        $users = User::join('role_user', 'user.id', 'role_user.user_id')
            ->leftJoin('email_user', 'user.id', 'email_user.user_id')
            ->leftJoin('email', 'email_user.email_id', 'email.id')
            ->where('role_user.role_code', 'sbs');

        $emails = Email::all();

        return view('admin/email', [
            'emails' => $emails,
            'users' => $users
        ]);
    }
}
