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
        $user = User::find($id);
        $this->authorize('show-profile', $user);

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
        $this->authorize('edit-profile', $user);

        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $profile = $user->profile;
        if (!$profile) {
            return abort(404);
        }
        $address = $user->address;
        if (!$address) {
            return abort(404);
        }

        return view('user/profile/edit', [
            'user' => $user,
            'profile' => $profile,
            'address' => $address,
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

        $profile = User::find($id)->profile;
        if (!$profile) {
            return abort(404);
        }

        $profile->phone = request('phone');
        $profile->date_of_birth = request('date_of_birth');
        $profile->ethnicity = request('ethnicity');
        $profile->gender = request('gender');
        $profile->headshot_url = request('headshot_url');
        $profile->employment_status = request('employment_status');
        $profile->job_seeking_status = request('job_seeking_status');
        $profile->receives_job_notifications = request('receives_job_notifications');
        $profile->department_interests_ticket_sales = request('department_interests_ticket_sales');
        $profile->department_interests_sponsorship_sales = request('department_interests_sponsorship_sales');
        $profile->department_interests_service = request('department_interests_service');
        $profile->department_interests_premium_sales = request('department_interests_premium_sales');
        $profile->department_interests_marketing = request('department_interests_marketing');
        $profile->department_interests_sponsorship_activation = request('department_interests_sponsorship_activation');
        $profile->department_interests_hr = request('department_interests_hr');
        $profile->department_interests_analytics = request('department_interests_analytics');
        $profile->department_interests_cr = request('department_interests_cr');
        $profile->department_interests_pr = request('department_interests_pr');
        $profile->department_interests_database = request('department_interests_database');
        $profile->department_interests_finance = request('department_interests_finance');
        $profile->department_interests_arena_ops = request('department_interests_arena_ops');
        $profile->department_interests_player_ops = request('department_interests_player_ops');
        $profile->department_interests_event_ops = request('department_interests_event_ops');
        $profile->department_interests_social_media = request('department_interests_social_media');
        $profile->department_interests_entertainment = request('department_interests_entertainment');
        $profile->department_interests_legal = request('department_interests_legal');
        $profile->department_interests_other = request('department_interests_other');
        $profile->job_decision_factors_other = request('job_decision_factors_other');
        $profile->employed_in_sports_sales = request('employed_in_sports_sales');
        $profile->continuing_sports_sales = request('continuing_sports_sales');
        $profile->next_sales_job = request('next_sales_job');
        $profile->is_sports_sales_manager = request('is_sports_sales_manager');
        $profile->continuing_management = request('continuing_management');
        $profile->next_management_job = request('next_management_job');
        $profile->is_executive = request('is_executive');
        $profile->continuing_executive = request('continuing_executive');
        $profile->next_executive = request('next_executive');
        $profile->works_in_sports = request('works_in_sports');
        $profile->years_in_sports = request('years_in_sports');
        $profile->current_organization = request('current_organization');
        $profile->current_region = request('current_region');
        $profile->current_department_ticket_sales = request('current_department_ticket_sales');
        $profile->current_department_sponsorship_sales = request('current_department_sponsorship_sales');
        $profile->current_department_service = request('current_department_service');
        $profile->current_department_premium_sales = request('current_department_premium_sales');
        $profile->current_department_marketing = request('current_department_marketing');
        $profile->current_department_sponsorship_activation = request('current_department_sponsorship_activation');
        $profile->current_department_hr = request('current_department_hr');
        $profile->current_department_analytics = request('current_department_analytics');
        $profile->current_department_cr = request('current_department_cr');
        $profile->current_department_pr = request('current_department_pr');
        $profile->current_department_database = request('current_department_database');
        $profile->current_department_finance = request('current_department_finance');
        $profile->current_department_arena_ops = request('current_department_arena_ops');
        $profile->current_department_player_ops = request('current_department_player_ops');
        $profile->current_department_event_ops = request('current_department_event_ops');
        $profile->current_department_social_media = request('current_department_social_media');
        $profile->current_department_entertainment = request('current_department_entertainment');
        $profile->current_department_legal = request('current_department_legal');
        $profile->current_department_other = request('current_department_other');
        $profile->current_title = request('current_title');
        $profile->years_current_organization = request('years_current_organization');
        $profile->years_current_role = request('years_current_role');
        $profile->department_experience_ticket_sales = request('department_experience_ticket_sales');
        $profile->department_experience_sponsorship_sales = request('department_experience_sponsorship_sales');
        $profile->department_experience_service = request('department_experience_service');
        $profile->department_experience_premium_sales = request('department_experience_premium_sales');
        $profile->department_experience_marketing = request('department_experience_marketing');
        $profile->department_experience_sponsorship_activation = request('department_experience_sponsorship_activation');
        $profile->department_experience_hr = request('department_experience_hr');
        $profile->department_experience_analytics = request('department_experience_analytics');
        $profile->department_experience_cr = request('department_experience_cr');
        $profile->department_experience_pr = request('department_experience_pr');
        $profile->department_experience_database = request('department_experience_database');
        $profile->department_experience_finance = request('department_experience_finance');
        $profile->department_experience_arena_ops = request('department_experience_arena_ops');
        $profile->department_experience_player_ops = request('department_experience_player_ops');
        $profile->department_experience_event_ops = request('department_experience_event_ops');
        $profile->department_experience_social_media = request('department_experience_social_media');
        $profile->department_experience_entertainment = request('department_experience_entertainment');
        $profile->department_experience_legal = request('department_experience_legal');
        $profile->department_experience_other = request('department_experience_other');
        $profile->if_not_organization = request('if_not_organization');
        $profile->if_not_department = request('if_not_department');
        $profile->if_not_title = request('if_not_title');
        $profile->if_not_years_current_organization = request('if_not_years_current_organization');
        $profile->if_not_years_current_role = request('if_not_years_current_role');
        $profile->if_not_department_experience_phone_sales = request('if_not_department_experience_phone_sales');
        $profile->if_not_department_experience_door_to_door_sales = request('if_not_department_experience_door_to_door_sales');
        $profile->if_not_department_experience_territory_management = request('if_not_department_experience_territory_management');
        $profile->if_not_department_experience_b2b_sales = request('if_not_department_experience_b2b_sales');
        $profile->if_not_department_experience_customer = request('if_not_department_experience_customer');
        $profile->if_not_department_experience_sponsorship = request('if_not_department_experience_sponsorship');
        $profile->if_not_department_experience_high_level_business_development = request('if_not_department_experience_high_level_business_development');
        $profile->if_not_department_experience_marketing = request('if_not_department_experience_marketing');
        $profile->if_not_department_experience_analytics = request('if_not_department_experience_analytics');
        $profile->if_not_department_experience_bi = request('if_not_department_experience_bi');
        $profile->if_not_department_experience_database = request('if_not_department_experience_database');
        $profile->if_not_department_experience_digital = request('if_not_department_experience_digital');
        $profile->if_not_department_experience_web_design = request('if_not_department_experience_web_design');
        $profile->if_not_department_experience_social_media = request('if_not_department_experience_social_media');
        $profile->if_not_department_experience_hr = request('if_not_department_experience_hr');
        $profile->if_not_department_experience_finance = request('if_not_department_experience_finance');
        $profile->if_not_department_experience_accounting = request('if_not_department_experience_accounting');
        $profile->if_not_department_experience_organizational_development = request('if_not_department_experience_organizational_development');
        $profile->if_not_department_experience_communications = request('if_not_department_experience_communications');
        $profile->if_not_department_experience_pr = request('if_not_department_experience_pr');
        $profile->if_not_department_experience_media_relations = request('if_not_department_experience_media_relations');
        $profile->if_not_department_experience_legal = request('if_not_department_experience_legal');
        $profile->if_not_department_experience_it = request('if_not_department_experience_it');
        $profile->if_not_department_experience_other = request('if_not_department_experience_other');
        $profile->resume_url = request('resume_url');
        $profile->education_level = request('education_level');
        $profile->college = request('college');
        $profile->graduation_year = request('graduation_year');
        $profile->gpa = request('gpa');
        $profile->college_organizations = request('college_organizations');
        $profile->college_sports_clubs = request('college_sports_clubs');
        $profile->has_school_plans = request('has_school_plans');
        $profile->email_preference_entry_job = request('email_preference_entry_job');
        $profile->email_preference_new_job = request('email_preference_new_job');
        $profile->email_preference_ticket_sales = request('email_preference_ticket_sales');
        $profile->email_preference_leadership = request('email_preference_leadership');
        $profile->email_preference_best_practices = request('email_preference_best_practices');
        $profile->email_preference_career_advice = request('email_preference_career_advice');
        $profile->edited_at = new \DateTime('NOW');
        $profile->save();

        return redirect()->action('ProfileController@show', [$profile]);
    }
}
