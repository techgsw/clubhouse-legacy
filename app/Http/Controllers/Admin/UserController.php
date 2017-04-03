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
    public function index()
    {
        $this->authorize('view-admin-users');

        $users = User::orderBy('id', 'desc')->paginate(5);

        return view('admin/user', [
            'users' => $users
        ]);
    }
}
