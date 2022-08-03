<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfile;
use App\Http\Requests\UpdateProfile;
use App\Image;
use App\Message;
use App\Note;
use App\Organization;
use App\Profile;
use App\Services\ProfileUpdateService;
use App\State;
use App\TagType;
use App\User;
use App\Providers\ImageServiceProvider;
use App\Providers\MailchimpServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use League\Flysystem\Filesystem;
use \Exception;

class ProfileController extends Controller
{
    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 'self')
    {
        if ($id == 'self' && Auth::user()) {
            $user = Auth::user();
        } else {
            $user = User::with(['profile', 'contact'])->find($id);
        }
        if (!$user) {
            return abort(404);
        }
        $this->authorize('view-profile', $user);

        $department_goals = [];
        collect(Profile::getDepartmentGoals())->each(function ($label, $goal) use ($user, &$department_goals) {
            if ($user->profile->$goal) {
                $department_goals[] = $label;
            }
        });

        $department_experience = [];
        collect(Profile::getExperienceDepartments())->each(function ($label, $experience) use ($user, &$department_experience) {
            if ($user->profile->$experience) {
                $department_experience[] = $label;
            }
        });

        $breadcrumb = array(
            'Home' => '/',
            'Contacts' => "/admin/contact",
            'User' => "/user/$id",
            'Profile' => "/user/$id/profile"
        );

        if (!Gate::allows('view-admin-dashboard')) {
            // Only admins should have contact search added to the breadcrumb
            unset($breadcrumb['Contacts']);
        }

        return view('user/profile', [
            'user' => $user,
            'profile' => $user->profile,
            'department_goals' => $department_goals,
            'department_experience' => $department_experience,
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 'self')
    {
        if ($id == 'self' && Auth::user()) {
            $user = Auth::user();
        } else {
            $user = User::find($id);
        }
        $this->authorize('edit-profile', $user);

        if (!$user) {
            return abort(404);
        }
        $profile = $user->profile;
        if (!$profile) {
            return abort(404);
        }
        $address = $user->profile->address[0];
        if (!$address) {
            return abort(404);
        }

        if ($profile->phone && strlen($profile->phone) == 10) {
            $profile->phone = "(".substr($profile->phone, 0, 3).")".substr($profile->phone, 3, 3)."-".substr($profile->phone, 6, 4);
        }

        if ($profile->secondary_phone && strlen($profile->secondary_phone) == 10) {
            $profile->secondary_phone = "(".substr($profile->secondary_phone, 0, 3).")".substr($profile->secondary_phone, 3, 3)."-".substr($profile->secondary_phone, 6, 4);
        }

        $job_tags = TagType::where('type', 'job')->get();

        $breadcrumb = array(
            'Home' => '/',
            'Contacts' => "/admin/contact",
            'User' => "/user/$id",
            'Profile' => "/user/$id/profile",
            'Edit' => "/user/$id/edit-profile"
        );

        if (!Gate::allows('view-admin-dashboard')) {
            // Only admins should have contact search added to the breadcrumb
            unset($breadcrumb['Contacts']);
        }


        return view('user/edit-profile', [
            'user' => $user,
            'profile' => $profile,
            'address' => $address,
            'job_tags' => $job_tags,
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * @param ProfileUpdateService $service
     * @param UpdateProfile $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ProfileUpdateService $service, UpdateProfile $request, $id)
    {
        $user = User::find($id);
        $this->authorize('edit-profile', $user);
        if (!$user) {
            return abort(404);
        }

        return $service->update($request, $user);
    }

    public function showUnsubscribeOptions($token)
    {
        if (!$token) {
            request()->session()->flash('message', new Message(
                "We could not find your profile from the link, please log in to edit the Email Preferences on your profile.",
                "danger",
                null,
                "error"
            ));
            session(['url.intended' => '/user/self/edit-profile']);
            return redirect('/login');
        }

        $profile = Profile::with('user')->where('email_unsubscribe_token', $token)->first();

        if (!$profile) {
            request()->session()->flash('message', new Message(
                "We could not find your profile from the link, please log in to edit the Email Preferences on your profile.",
                "danger",
                null,
                "error"
            ));
            session(['url.intended' => '/user/self/edit-profile']);
            return redirect('/login');
        }

        return view('user/unsubscribe', [
            'profile' => $profile,
        ]);
    }

    public function unsubscribe($token)
    {
        $request = request();

        if (
            !$request->get('email_preference_marketing_opt_out')
            && !$request->get('email_preference_new_content_opt_out')
            && !$request->get('email_preference_new_job_opt_out')
            && !$request->get('email_preference_newsletter_opt_out')
        ) {
            return redirect()->back()->withErrors([
                'msg' => "Please select the content you would like to unsubscribe from"
            ]);
        }

        if (!$token) {
            return redirect()->back()->withErrors([
                'msg' => "There was an issue updating your profile, please try again or log in to edit your email preferences."
            ]);
        }

        $profile = Profile::with('user')->where('email_unsubscribe_token', $token)->first();

        if (!$profile) {
            return redirect()->back()->withErrors([
                'msg' => "There was an issue updating your profile, please try again or log in to edit your email preferences."
            ]);
        }

        if ($request->get('email_preference_marketing_opt_out')) {
            $profile->email_preference_marketing = false;
        }
        if ($request->get('email_preference_new_content_opt_out')) {
            $profile->email_preference_new_content_blogs = false;
            $profile->email_preference_new_content_webinars = false;
            $profile->email_preference_new_content_mentors = false;
            $profile->email_preference_new_content_training_videos = false;
        }
        if ($request->get('email_preference_new_job_opt_out')) {
            $profile->email_preference_new_job = false;
        }
        $profile->save();

        try {
            if (request('email_preference_newsletter_opt_out') && !is_null($profile->user->mailchimp_subscriber_hash)) {
                MailchimpServiceProvider::deleteFromMailchimp($profile->user);
            }
        } catch (\Throwable $t) {
            Log::error($t->getMessage());
            return redirect()->back()->withErrors([
                'msg' => "There was an issue unsubscribing you from the newsletter. Please try again or contact ' . __('email.info_address') . ' for assistance.",
            ]);
        }

        return view('user/unsubscribe-thanks', [
            'profile' => $profile,
        ]);
    }

    public function dontAskToComplete($id = 'self')
    {
        $user = User::find($id);

        if ($user) {
            $user->profile->dont_ask = true;
            $user->profile->update();
        }

        return redirect()->back();
    }
}
