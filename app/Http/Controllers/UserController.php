<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * View profile
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        $this->user = Auth::user();
        return view('user/show', [
            'user' => $this->user
        ]);
    }

    /**
     * Edit profile
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request)
    {
        $this->user = Auth::user();
        return view('user/edit', [
            'user' => $this->user
        ]);
    }

    /**
     * Save profile changes
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, []);

        // TODO Process

        return redirect()->action('ProfileController@edit');
    }


}
