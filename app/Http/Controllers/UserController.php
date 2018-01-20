<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * View profile
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $this->authorize('view-user', $user);

        return redirect("/user/{$id}/profile");
    }

    public function jobs(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $this->authorize('view-user', $user);

        return view('user/jobs', [
            'breadcrumb' => [
                'Home' => '/',
                'User' => "/user/{$user->id}",
                'Jobs' => "/user/{$user->id}/jobs"
            ],
            'user' => $user
        ]);
    }

    public function questions(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $this->authorize('view-user', $user);

        return view('user/questions', [
            'breadcrumb' => [
                'Home' => '/',
                'User' => "/user/{$user->id}",
                'Questions' => "/user/{$user->id}/questions"
            ],
            'user' => $user
        ]);
    }

    /**
     * Edit profile
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $this->authorize('edit-user', $user);

        return view('user/edit', [
            'breadcrumb' => ['Home' => '/', 'Profile' => "/user/{$user->id}", 'Edit' => "/user/{$user->id}/edit"],
            'user' => $user
        ]);
    }

    /**
     * Save profile changes
     *
     * @param  UpdateUser  $request
     * @return Response
     */
    public function update(UpdateUser $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->email = request('email');
        $user->title = request('title');
        $user->organization = request('organization');
        $user->is_sales_professional = request('is_sales_professional') && request('is_sales_professional') == "on";
        //$user->receives_newsletter = request('receives_newsletter') && request('receives_newsletter') == "on";
        $user->is_interested_in_jobs = request('is_interested_in_jobs') && request('is_interested_in_jobs') == "on";
        $user->save();

        // TODO MailChimp newsletter event

        return redirect()->action('UserController@show', [$user]);
    }
}
