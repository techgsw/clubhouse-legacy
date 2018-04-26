<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfile;
use App\Http\Requests\UpdateProfile;
use App\Image;
use App\Message;
use App\Note;
use App\Profile;
use App\User;
use App\Providers\ImageServiceProvider;
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
    public function show($id)
    {
        $user = User::with(['profile', 'contact'])->find($id);
        if (!$user) {
            return abort(404);
        }
        $this->authorize('view-profile', $user);

        $department_goals = [];
        if ($user->profile->department_goals_ticket_sales) {
            $department_goals[] = "Ticket Sales";
        }
        if ($user->profile->department_goals_sponsorship_sales) {
            $department_goals[] = "Sponsorship Sales";
        }
        if ($user->profile->department_goals_service) {
            $department_goals[] = "Service";
        }
        if ($user->profile->department_goals_premium_sales) {
            $department_goals[] = "Premium Sales";
        }
        if ($user->profile->department_goals_marketing) {
            $department_goals[] = "Marketing";
        }
        if ($user->profile->department_goals_sponsorship_activation) {
            $department_goals[] = "Sponsorship Activation";
        }
        if ($user->profile->department_goals_hr) {
            $department_goals[] = "Human Resources";
        }
        if ($user->profile->department_goals_analytics) {
            $department_goals[] = "Analytics";
        }
        if ($user->profile->department_goals_cr) {
            $department_goals[] = "Community Relations";
        }
        if ($user->profile->department_goals_pr) {
            $department_goals[] = "Public Relations";
        }
        if ($user->profile->department_goals_database) {
            $department_goals[] = "Database";
        }
        if ($user->profile->department_goals_finance) {
            $department_goals[] = "Finance";
        }
        if ($user->profile->department_goals_arena_ops) {
            $department_goals[] = "Arena Ops";
        }
        if ($user->profile->department_goals_player_ops) {
            $department_goals[] = "Player Ops";
        }
        if ($user->profile->department_goals_event_ops) {
            $department_goals[] = "Event Ops";
        }
        if ($user->profile->department_goals_social_media) {
            $department_goals[] = "Social Media";
        }
        if ($user->profile->department_goals_entertainment) {
            $department_goals[] = "Entertainment";
        }
        if ($user->profile->department_goals_legal) {
            $department_goals[] = "Legal";
        }
        if ($user->profile->department_goals_other) {
            $department_goals[] = $user->profile->department_goals_other;
        }

        $department_experience = [];
        if ($user->profile->department_experience_ticket_sales) {
            $department_experience[] = "Ticket Sales";
        }
        if ($user->profile->department_experience_sponsorship_sales) {
            $department_experience[] = "Sponsorship Sales";
        }
        if ($user->profile->department_experience_service) {
            $department_experience[] = "Service";
        }
        if ($user->profile->department_experience_premium_sales) {
            $department_experience[] = "Premium Sales";
        }
        if ($user->profile->department_experience_marketing) {
            $department_experience[] = "Marketing";
        }
        if ($user->profile->department_experience_sponsorship_activation) {
            $department_experience[] = "Sponsorship Activation";
        }
        if ($user->profile->department_experience_hr) {
            $department_experience[] = "Human Resources";
        }
        if ($user->profile->department_experience_analytics) {
            $department_experience[] = "Analytics";
        }
        if ($user->profile->department_experience_cr) {
            $department_experience[] = "Community Relations";
        }
        if ($user->profile->department_experience_pr) {
            $department_experience[] = "Public Relations";
        }
        if ($user->profile->department_experience_database) {
            $department_experience[] = "Database";
        }
        if ($user->profile->department_experience_finance) {
            $department_experience[] = "Finance";
        }
        if ($user->profile->department_experience_arena_ops) {
            $department_experience[] = "Arena Ops";
        }
        if ($user->profile->department_experience_player_ops) {
            $department_experience[] = "Player Ops";
        }
        if ($user->profile->department_experience_event_ops) {
            $department_experience[] = "Event Ops";
        }
        if ($user->profile->department_experience_social_media) {
            $department_experience[] = "Social Media";
        }
        if ($user->profile->department_experience_entertainment) {
            $department_experience[] = "Entertainment";
        }
        if ($user->profile->department_experience_legal) {
            $department_experience[] = "Legal";
        }
        if ($user->profile->department_experience_other) {
            $department_experience[] = $user->profile->department_experience_other;
        }

        return view('user/profile', [
            'user' => $user,
            'profile' => $user->profile,
            'department_goals' => $department_goals,
            'department_experience' => $department_experience,
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
        $user = User::find($id);
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

        $personal_complete =
            $profile->date_of_birth &&
            $profile->ethnicity &&
            $profile->gender;

        $address_complete =
            $address->line1 &&
            $address->city &&
            $address->state &&
            $address->postal_code &&
            $address->country;

        $job_preferences_complete =
            $profile->job_seeking_status &&
            $profile->job_seeking_type &&
            $profile->job_seeking_region && (
                // At least one department goal
                $profile->department_goals_ticket_sales ||
                $profile->department_goals_sponsorship_sales ||
                $profile->department_goals_service ||
                $profile->department_goals_premium_sales ||
                $profile->department_goals_marketing ||
                $profile->department_goals_sponsorship_activation ||
                $profile->department_goals_hr ||
                $profile->department_goals_analytics ||
                $profile->department_goals_cr ||
                $profile->department_goals_pr ||
                $profile->department_goals_database ||
                $profile->department_goals_finance ||
                $profile->department_goals_arena_ops ||
                $profile->department_goals_player_ops ||
                $profile->department_goals_event_ops ||
                $profile->department_goals_social_media ||
                $profile->department_goals_entertainment ||
                $profile->department_goals_legal ||
                $profile->department_goals_other
            ) && (
                // At least one job factor
                $profile->job_factors_money ||
                $profile->job_factors_title ||
                $profile->job_factors_location ||
                $profile->job_factors_organization ||
                $profile->job_factors_other
            );

        $employment_complete =
            !is_null($profile->works_in_sports) &&
            $profile->current_organization &&
            $profile->current_title &&
            $profile->current_region &&
            $profile->current_organization_years &&
            $profile->current_title_years && (
                // At least one department experience
                $profile->department_experience_ticket_sales ||
                $profile->department_experience_sponsorship_sales ||
                $profile->department_experience_service ||
                $profile->department_experience_premium_sales ||
                $profile->department_experience_marketing ||
                $profile->department_experience_sponsorship_activation ||
                $profile->department_experience_hr ||
                $profile->department_experience_analytics ||
                $profile->department_experience_cr ||
                $profile->department_experience_pr ||
                $profile->department_experience_database ||
                $profile->department_experience_finance ||
                $profile->department_experience_arena_ops ||
                $profile->department_experience_player_ops ||
                $profile->department_experience_event_ops ||
                $profile->department_experience_social_media ||
                $profile->department_experience_entertainment ||
                $profile->department_experience_legal ||
                $profile->department_experience_other
            );

        $education_complete =
            $profile->education_level &&
            !is_null($profile->has_school_plans);

        if ($profile->phone && strlen($profile->phone) == 10) {
            $profile->phone = "(".substr($profile->phone, 0, 3).")".substr($profile->phone, 3, 3)."-".substr($profile->phone, 6, 4);
        }

        return view('user/edit-profile', [
            'user' => $user,
            'profile' => $profile,
            'address' => $address,
            'personal_complete' => $personal_complete,
            'address_complete' => $address_complete,
            'job_preferences_complete' => $job_preferences_complete,
            'employment_complete' => $employment_complete,
            'education_complete' => $education_complete,
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
        $user = User::find($id);
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
        $contact = $user->contact;
        if (!$contact) {
            return abort(404);
        }

        $image_error = false;

        try {
            if ($headshot = request()->file('headshot_url')) {
                $image = ImageServiceProvider::saveFileAsImage(
                    $headshot,
                    $filename = preg_replace('/\s/', '-', str_replace("/", "", $user->first_name.'-'.$user->last_name)).'-SportsBusinessSolutions',
                    $directory = 'headshot/'.$user->id,
                    $options = [
                        'cropFromCenter' => true,
                        'update' => $profile->headshotImage ?: null
                    ]
                );

                $profile->headshot_image_id = $image->id;
                $profile->save();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $image_error = true;
        }

        try {
            $resume = request()->file('resume_url');
            if ($resume) {
                $r = $resume->store('resume', 'public');
            } else {
                $r = null;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        $profile->phone = request('phone')
            ? preg_replace("/[^\d]/", "", request('phone'))
            : null;
        $profile->resume_url = $r ?: $profile->resume_url;
        // Personal Information
        $birthday = new \DateTime(request('date_of_birth'));
        $profile->date_of_birth = $birthday->format('Y-m-d');
        $profile->ethnicity = request('ethnicity');
        $profile->gender = request('gender');
        // Address
        $address->line1 = request('line1');
        $address->line2 = request('line2');
        $address->city = request('city');
        $address->state = request('state');
        $address->postal_code = request('postal_code');
        $address->country = request('country');
        $address->updated_at = new \DateTime('NOW');
        $address->save();
        // Job-seeking status
        $profile->job_seeking_status = request('job_seeking_status');
        $profile->job_seeking_type = request('job_seeking_type');
        $profile->job_seeking_region = request('job_seeking_region');
        $profile->department_goals_ticket_sales = request('department_goals_ticket_sales') ? true : false;
        $profile->department_goals_sponsorship_sales = request('department_goals_sponsorship_sales') ? true : false;
        $profile->department_goals_service = request('department_goals_service') ? true : false;
        $profile->department_goals_premium_sales = request('department_goals_premium_sales') ? true : false;
        $profile->department_goals_marketing = request('department_goals_marketing') ? true : false;
        $profile->department_goals_sponsorship_activation = request('department_goals_sponsorship_activation') ? true : false;
        $profile->department_goals_hr = request('department_goals_hr') ? true : false;
        $profile->department_goals_analytics = request('department_goals_analytics') ? true : false;
        $profile->department_goals_cr = request('department_goals_cr') ? true : false;
        $profile->department_goals_pr = request('department_goals_pr') ? true : false;
        $profile->department_goals_database = request('department_goals_database') ? true : false;
        $profile->department_goals_finance = request('department_goals_finance') ? true : false;
        $profile->department_goals_arena_ops = request('department_goals_arena_ops') ? true : false;
        $profile->department_goals_player_ops = request('department_goals_player_ops') ? true : false;
        $profile->department_goals_event_ops = request('department_goals_event_ops') ? true : false;
        $profile->department_goals_social_media = request('department_goals_social_media') ? true : false;
        $profile->department_goals_entertainment = request('department_goals_entertainment') ? true : false;
        $profile->department_goals_legal = request('department_goals_legal') ? true : false;
        $profile->department_goals_other = request('department_goals_other');
        $profile->job_factors_money = request('job_factors_money') ? true : false;
        $profile->job_seeking_income = request('job_seeking_income');
        $profile->job_factors_title = request('job_factors_title') ? true : false;
        $profile->job_seeking_title = request('job_seeking_title');
        $profile->job_factors_location = request('job_factors_location') ? true : false;
        $profile->job_factors_organization = request('job_factors_organization') ? true : false;
        $profile->job_seeking_organizations = request('job_seeking_organizations');
        $profile->job_factors_other = request('job_factors_other');
        // Employment history
        $profile->works_in_sports = request('works_in_sports') ? true : false;
        $profile->current_organization = request('current_organization');
        $profile->current_title = request('current_title');
        $profile->current_region = request('current_region');
        $profile->current_organization_years = request('current_organization_years');
        $profile->current_title_years = request('current_title_years');
        $profile->department_experience_ticket_sales = request('department_experience_ticket_sales') ? true : false;
        $profile->department_experience_sponsorship_sales = request('department_experience_sponsorship_sales') ? true : false;
        $profile->department_experience_service = request('department_experience_service') ? true : false;
        $profile->department_experience_premium_sales = request('department_experience_premium_sales') ? true : false;
        $profile->department_experience_marketing = request('department_experience_marketing') ? true : false;
        $profile->department_experience_sponsorship_activation = request('department_experience_sponsorship_activation') ? true : false;
        $profile->department_experience_hr = request('department_experience_hr') ? true : false;
        $profile->department_experience_analytics = request('department_experience_analytics') ? true : false;
        $profile->department_experience_cr = request('department_experience_cr') ? true : false;
        $profile->department_experience_pr = request('department_experience_pr') ? true : false;
        $profile->department_experience_database = request('department_experience_database') ? true : false;
        $profile->department_experience_finance = request('department_experience_finance') ? true : false;
        $profile->department_experience_arena_ops = request('department_experience_arena_ops') ? true : false;
        $profile->department_experience_player_ops = request('department_experience_player_ops') ? true : false;
        $profile->department_experience_event_ops = request('department_experience_event_ops') ? true : false;
        $profile->department_experience_social_media = request('department_experience_social_media') ? true : false;
        $profile->department_experience_entertainment = request('department_experience_entertainment') ? true : false;
        $profile->department_experience_legal = request('department_experience_legal') ? true : false;
        $profile->department_experience_other = request('department_experience_other');
        // Education history
        $profile->education_level = request('education_level');
        $profile->college_name = request('college_name');
        $profile->college_graduation_year = request('college_graduation_year');
        $profile->college_gpa = request('college_gpa');
        $profile->college_organizations = request('college_organizations');
        $profile->college_sports_clubs = request('college_sports_clubs');
        $profile->has_school_plans = request('has_school_plans');
        // Email preferences
        $profile->email_preference_entry_job = request('email_preference_entry_job') ? true : false;
        $profile->email_preference_new_job = request('email_preference_new_job') ? true : false;
        $profile->email_preference_ticket_sales = request('email_preference_ticket_sales') ? true : false;
        $profile->email_preference_leadership = request('email_preference_leadership') ? true : false;
        $profile->email_preference_best_practices = request('email_preference_best_practices') ? true : false;
        $profile->email_preference_career_advice = request('email_preference_career_advice') ? true : false;
        // Timestamp(s)
        $profile->updated_at = new \DateTime('NOW');

        try {
            $profile->save();
        } catch (\Exception $e) {
            $request->session()->flash('message', new Message(
                "There was an error saving your profile. Please check your submission and try again.",
                "warning",
                $code = null,
                $icon = "warning"
            ));
            return redirect()->back()->withInput();
        }

        // Contact
        // Fill in fields if they are not set
        if (is_null($contact->phone)) {
            $contact->phone = request('phone')
                ? preg_replace("/[^\d]/", "", request('phone'))
                : null;
        }
        if (is_null($contact->title)) {
            $contact->title = request('current_title');
        }
        if (is_null($contact->organization)) {
            $contact->organization = request('current_organization');
        }
        if (is_null($contact->job_seeking_type)) {
            $contact->job_seeking_type = request('job_seeking_type');
        }
        if (is_null($contact->job_seeking_status)) {
            $contact->job_seeking_status = request('job_seeking_status');
        }
        try {
            $contact->save();
        } catch (\Exception $e) {
            $request->session()->flash('message', new Message(
                "There was an error saving your profile. Please check your submission and try again.",
                "warning",
                $code = null,
                $icon = "warning"
            ));
            return redirect()->back()->withInput();
        }

        // Address
        if (is_null($contact->address[0]->line1)) {
            $contact->address[0]->line1 = request('line1');
        }
        if (is_null($contact->address[0]->line2)) {
            $contact->address[0]->line2 = request('line2');
        }
        if (is_null($contact->address[0]->city)) {
            $contact->address[0]->city = request('city');
        }
        if (is_null($contact->address[0]->state)) {
            $contact->address[0]->state = request('state');
        }
        if (is_null($contact->address[0]->postal_code)) {
            $contact->address[0]->postal_code = request('postal_code');
        }
        if (is_null($contact->address[0]->country)) {
            $contact->address[0]->country = request('country');
        }
        try {
            $contact->address[0]->save();
        } catch (\Exception $e) {
            $request->session()->flash('message', new Message(
                "There was an error saving your address. Please check your submission and try again.",
                "warning",
                $code = null,
                $icon = "warning"
            ));
            return redirect()->back()->withInput();
        }

        if ($image_error) {
            $request->session()->flash('message', new Message(
                "Sorry, your profile image failed to upload. Please try a different image.",
                "danger",
                $code = null,
                $icon = "error"
            ));
        } else {
            $request->session()->flash('message', new Message(
                "Profile saved",
                "success",
                $code = null,
                $icon = "check_circle"
            ));
        }

        return redirect()->action('ProfileController@edit', [$user]);
    }
}
