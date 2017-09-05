<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfile;
use App\Http\Requests\UpdateProfile;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use \Exception;

class ProfileController extends Controller
{
    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO permission

        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $profile = $user->profile;
        if (!$profile) {
            return abort(404);
        }

        return view('user/profile/show', [
            'user' => $user,
            'profile' => $profile,
            'breadcrumb' => [
                'Home' => '/',
                'User' => "/user/$id",
                'Profile' => "/user/$id/profile"
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $profile = $user->profile;
        if (!$profile) {
            return abort(404);
        }

        // TODO permission
        // $this->authorize('edit-profile', $profile);

        return view('user/profile/edit', [
            'user' => $user,
            'profile' => $profile,
            'breadcrumb' => [
                'Home' => '/',
                'User' => "/user/$id",
                'Profile' => "/user/$id/profile",
                'Edit' => "/user/$id/edit-profile"
            ]
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfile $request, $id)
    {
        $profile = User::find($id)->profile;
        if (!$profile) {
            return abort(404);
        }

        // TODO NIKO
        $profile->edited_at = new \DateTime('NOW');
        $profile->save();

        return redirect()->action('ProfileController@show', [$profile]);
    }
}
