<?php

namespace App\Http\Controllers;

use App\Email;
use App\Message;
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

        $users = User::join('role_user', 'user.id', 'role_user.user_id')
            ->where('role_user.role_code', 'sbs')
            ->get();

        $emails = Email::all();

        return view('admin/email', [
            'emails' => $emails,
            'users' => $users
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('edit-email');

        $ucx = User::join('role_user', 'user.id', 'role_user.user_id')
            ->where('role_user.role_code', 'sbs');

        $users = [];
        foreach ($ucx->get() as $user) {
            $users[$user->id] = $user;
        }

        foreach ($users as $id => $user) {
            $email_ids = [];
            if (array_key_exists($user->id, $request->user)) {
                $email_ids = array_keys($request->user[$user->id]);
            }
            $user = User::find($id)->emails()->sync($email_ids);
        }

        $message = new Message(
            "Email settings updated.",
            "success",
            $code = null,
            $icon = null
        );
        $request->session()->flash('message', $message);
        return redirect()->back();
    }
}
