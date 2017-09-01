<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfile;
use App\Http\Requests\UpdateProfile;
use App\Inquiry;
use App\Profile;
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
        // TODO permissions ?

        $profile = User::find($id)->profile;
        if (!$profile) {
            return abort(404);
        }

        // TODO permissions

        return view('profile/show', [
            'profile' => $profile,
            'breadcrumb' => [
                'Home' => '/',
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
        $profile = User::find($id)->profile;
        if (!$profile) {
            return abort(404);
        }

        // TODO permission
        $this->authorize('edit-profile', $profile);

        return view('profile/edit', [
            'profile' => $profile,
            'breadcrumb' => [
                'Home' => '/',
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
