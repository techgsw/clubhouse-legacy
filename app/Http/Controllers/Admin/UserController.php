<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
}
