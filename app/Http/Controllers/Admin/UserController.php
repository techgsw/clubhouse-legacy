<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-admin-users');

        $users = User::search($request);
        $count = $users->count();
        $users = $users->paginate(15);

        return view('admin/user', [
            'users' => $users,
            'count' => $count
        ]);
    }

    public function allAdminUsers()
    {
        $this->authorize('view-admin-dashboard');

        $users = User::join('role_user', 'user.id', '=', 'role_user.user_id')
            ->where('role_code','=','administrator')
            ->get();

        return response()->json([
            'error' => null,
            'users' => $users
        ]);
        
    }

    public function showLinkAccountSuggestions(Request $request) {
        $primary_user = User::find($request->user_id);

        $duplicate_suggestions = User::where('first_name', $primary_user->first_name)
            ->where('last_name', $primary_user->last_name)
            ->where('id', '!=', $request->user_id)
            ->whereNull('linked_user_id')
            ->get();


        $suggested_emails = array();
        foreach ($duplicate_suggestions as $suggestion) {
            $suggested_emails []= $suggestion->email;
        }

        return response()->json([
            'suggested_emails' => $suggested_emails
        ]);
    }

    public function linkAccounts(Request $request) {
        try {
            $primary_user = User::find($request->input('primary_user_id'));

            $duplicate_users = array();

            foreach ($request->input('email') as $email) {
                $user = User::with('contact')->where('email', $email)->first();
                if (!is_null($email) && !is_null($user)) {
                    $duplicate_users [] = $user;
                }
            }

            if (!empty($duplicate_users)) {
                $primary_user->linkUsersToThisAccount($duplicate_users);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->back();
    }

    public function unlinkAccount($id) {
        $linked_user = User::find($id);
        $linked_user->linked_user_id = null;
        $linked_user->save();
        return redirect()->back();
    }
}
