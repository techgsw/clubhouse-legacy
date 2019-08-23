<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Mail;
use App\Note;
use App\User;
use App\Role;
use App\RoleUser;
use App\Inquiry;
use App\Message;
use App\Providers\EmailServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request) 
    {
        $this->authorize('edit-roles');

        $user = User::find($request->id);

        $roles = Role::all();

        return view('user/roles', [
            'breadcrumb' => [
                'Home' => '/',
                'Account' => "/user/{$user->id}/account"
            ],
            'roles' => $roles,
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('edit-roles');

        // select * from user
	    // join role_user
        // where role_user.id = 107;
        
        $ucx = User::join('role_user', 'role_user.user_id', 'user.id')
            ->where('role_user.user_id', $request->id)
            ->get();

        $users = [];
        foreach ($ucx as $user) {
            $users[$user->id] = $user;
        }

        foreach ($users as $id => $user) {
            $role_ids = [];
            if (array_key_exists($user->id, $request->user)) {
                $role_ids = array_keys($request->user[$user->id]);
            }

            $user = User::find($request->id)->roles()->sync($role_ids);
        }

        $message = new Message(
            "Role settings updated.",
            "success",
            $code = null,
            $icon = null
        );
        $request->session()->flash('message', $message);
        return redirect()->back();
    }
}
