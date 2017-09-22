<!-- /resources/views/user/profile/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @can ('edit-profile', $user)
                <div class="input-field right">
                    <a href="/user/{{ $user->id }}/edit-profile" class="btn sbs-red">Edit</a>
                </div>
            @endcan
            <h3 class="header">{{ $user->getName() }}</h3>
            <p class="small">Joined {{ $user->created_at->format('F j, Y g:ia') }}</p>
            <p class="small">Last updated {{ $user->updated_at->format('F j, Y g:ia') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Address</h4>
            <p><b>{{ $user->address->line1 }}</b></p>
            <p><b>{{ $user->address->line2 }}</b></p>
            <p><b>{{ $user->address->city }}, {{ $user->address->state }} {{ $user->address->postal_code }}</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Profile</h4>
            <p>email: <b>{{ $user->email }}</b></p>
            <p>phone: <b>{{ $user->profile->phone }}</b></p>
            <p>date_of_birth: <b>{{ $user->profile->date_of_birth }}</b></p>
            <p>ethnicity: <b>{{ $user->profile->ethnicity }}</b></p>
            <p>gender: <b>{{ $user->profile->gender }}</b></p>
            <p>headshot_url: <b>{{ $user->profile->headshot_url }}</b></p>
            <p>employment_status: <b>{{ $user->profile->employment_status }}</b></p>
            <p>job_seeking_status: <b>{{ $user->profile->job_seeking_status }}</b></p>
            <p>receives_job_notifications: <b>{{ $user->profile->receives_job_notifications }}</b></p>
            <p>department_interests_ticket_sales: <b>{{ $user->profile->department_interests_ticket_sales }}</b></p>
            <p>department_interests_sponsorship_sales: <b>{{ $user->profile->department_interests_sponsorship_sales }}</b></p>
            <p>department_interests_service: <b>{{ $user->profile->department_interests_service }}</b></p>
            <p>department_interests_premium_sales: <b>{{ $user->profile->department_interests_premium_sales }}</b></p>
            <p>department_interests_marketing: <b>{{ $user->profile->department_interests_marketing }}</b></p>
            <p>department_interests_sponsorship_activation: <b>{{ $user->profile->department_interests_sponsorship_activation }}</b></p>
            <p>department_interests_hr: <b>{{ $user->profile->department_interests_hr }}</b></p>
            <p>department_interests_analytics: <b>{{ $user->profile->department_interests_analytics }}</b></p>
            <p>department_interests_cr: <b>{{ $user->profile->department_interests_cr }}</b></p>
            <p>department_interests_pr: <b>{{ $user->profile->department_interests_pr }}</b></p>
            <p>department_interests_database: <b>{{ $user->profile->department_interests_database }}</b></p>
            <p>department_interests_finance: <b>{{ $user->profile->department_interests_finance }}</b></p>
            <p>department_interests_arena_ops: <b>{{ $user->profile->department_interests_arena_ops }}</b></p>
            <p>department_interests_player_ops: <b>{{ $user->profile->department_interests_player_ops }}</b></p>
            <p>department_interests_event_ops: <b>{{ $user->profile->department_interests_event_ops }}</b></p>
            <p>department_interests_social_media: <b>{{ $user->profile->department_interests_social_media }}</b></p>
            <p>department_interests_entertainment: <b>{{ $user->profile->department_interests_entertainment }}</b></p>
            <p>department_interests_legal: <b>{{ $user->profile->department_interests_legal }}</b></p>
            <p>department_interests_other: <b>{{ $user->profile->department_interests_other }}</b></p>
            <p>job_decision_factors_other: <b>{{ $user->profile->job_decision_factors_other }}</b></p>
            <p>employed_in_sports_sales: <b>{{ $user->profile->employed_in_sports_sales }}</b></p>
            <p>continuing_sports_sales: <b>{{ $user->profile->continuing_sports_sales }}</b></p>
            <p>next_sales_job: <b>{{ $user->profile->next_sales_job }}</b></p>
            <p>is_sports_sales_manager: <b>{{ $user->profile->is_sports_sales_manager }}</b></p>
            <p>continuing_management: <b>{{ $user->profile->continuing_management }}</b></p>
            <p>next_management_job: <b>{{ $user->profile->next_management_job }}</b></p>
            <p>is_executive: <b>{{ $user->profile->is_executive }}</b></p>
            <p>continuing_executive: <b>{{ $user->profile->continuing_executive }}</b></p>
            <p>next_executive: <b>{{ $user->profile->next_executive }}</b></p>
            <p>works_in_sports: <b>{{ $user->profile->works_in_sports }}</b></p>
            <p>years_in_sports: <b>{{ $user->profile->years_in_sports }}</b></p>
            <p>current_organization: <b>{{ $user->profile->current_organization }}</b></p>
            <p>current_region: <b>{{ $user->profile->current_region }}</b></p>
            <p>current_department_ticket_sales: <b>{{ $user->profile->current_department_ticket_sales }}</b></p>
            <p>current_department_sponsorship_sales: <b>{{ $user->profile->current_department_sponsorship_sales }}</b></p>
            <p>current_department_service: <b>{{ $user->profile->current_department_service }}</b></p>
            <p>current_department_premium_sales: <b>{{ $user->profile->current_department_premium_sales }}</b></p>
            <p>current_department_marketing: <b>{{ $user->profile->current_department_marketing }}</b></p>
            <p>current_department_sponsorship_activation: <b>{{ $user->profile->current_department_sponsorship_activation }}</b></p>
            <p>current_department_hr: <b>{{ $user->profile->current_department_hr }}</b></p>
            <p>current_department_analytics: <b>{{ $user->profile->current_department_analytics }}</b></p>
            <p>current_department_cr: <b>{{ $user->profile->current_department_cr }}</b></p>
            <p>current_department_pr: <b>{{ $user->profile->current_department_pr }}</b></p>
            <p>current_department_database: <b>{{ $user->profile->current_department_database }}</b></p>
            <p>current_department_finance: <b>{{ $user->profile->current_department_finance }}</b></p>
            <p>current_department_arena_ops: <b>{{ $user->profile->current_department_arena_ops }}</b></p>
            <p>current_department_player_ops: <b>{{ $user->profile->current_department_player_ops }}</b></p>
            <p>current_department_event_ops: <b>{{ $user->profile->current_department_event_ops }}</b></p>
            <p>current_department_social_media: <b>{{ $user->profile->current_department_social_media }}</b></p>
            <p>current_department_entertainment: <b>{{ $user->profile->current_department_entertainment }}</b></p>
            <p>current_department_legal: <b>{{ $user->profile->current_department_legal }}</b></p>
            <p>current_department_other: <b>{{ $user->profile->current_department_other }}</b></p>
            <p>current_title: <b>{{ $user->profile->current_title }}</b></p>
            <p>years_current_organization: <b>{{ $user->profile->years_current_organization }}</b></p>
            <p>years_current_role: <b>{{ $user->profile->years_current_role }}</b></p>
            <p>department_experience_ticket_sales: <b>{{ $user->profile->department_experience_ticket_sales }}</b></p>
            <p>department_experience_sponsorship_sales: <b>{{ $user->profile->department_experience_sponsorship_sales }}</b></p>
            <p>department_experience_service: <b>{{ $user->profile->department_experience_service }}</b></p>
            <p>department_experience_premium_sales: <b>{{ $user->profile->department_experience_premium_sales }}</b></p>
            <p>department_experience_marketing: <b>{{ $user->profile->department_experience_marketing }}</b></p>
            <p>department_experience_sponsorship_activation: <b>{{ $user->profile->department_experience_sponsorship_activation }}</b></p>
            <p>department_experience_hr: <b>{{ $user->profile->department_experience_hr }}</b></p>
            <p>department_experience_analytics: <b>{{ $user->profile->department_experience_analytics }}</b></p>
            <p>department_experience_cr: <b>{{ $user->profile->department_experience_cr }}</b></p>
            <p>department_experience_pr: <b>{{ $user->profile->department_experience_pr }}</b></p>
            <p>department_experience_database: <b>{{ $user->profile->department_experience_database }}</b></p>
            <p>department_experience_finance: <b>{{ $user->profile->department_experience_finance }}</b></p>
            <p>department_experience_arena_ops: <b>{{ $user->profile->department_experience_arena_ops }}</b></p>
            <p>department_experience_player_ops: <b>{{ $user->profile->department_experience_player_ops }}</b></p>
            <p>department_experience_event_ops: <b>{{ $user->profile->department_experience_event_ops }}</b></p>
            <p>department_experience_social_media: <b>{{ $user->profile->department_experience_social_media }}</b></p>
            <p>department_experience_entertainment: <b>{{ $user->profile->department_experience_entertainment }}</b></p>
            <p>department_experience_legal: <b>{{ $user->profile->department_experience_legal }}</b></p>
            <p>department_experience_other: <b>{{ $user->profile->department_experience_other }}</b></p>
            <p>if_not_organization: <b>{{ $user->profile->if_not_organization }}</b></p>
            <p>if_not_department: <b>{{ $user->profile->if_not_department }}</b></p>
            <p>if_not_title: <b>{{ $user->profile->if_not_title }}</b></p>
            <p>if_not_years_current_organization: <b>{{ $user->profile->if_not_years_current_organization }}</b></p>
            <p>if_not_years_current_role: <b>{{ $user->profile->if_not_years_current_role }}</b></p>
            <p>if_not_department_experience_phone_sales: <b>{{ $user->profile->if_not_department_experience_phone_sales }}</b></p>
            <p>if_not_department_experience_door_to_door_sales: <b>{{ $user->profile->if_not_department_experience_door_to_door_sales }}</b></p>
            <p>if_not_department_experience_territory_management: <b>{{ $user->profile->if_not_department_experience_territory_management }}</b></p>
            <p>if_not_department_experience_b2b_sales: <b>{{ $user->profile->if_not_department_experience_b2b_sales }}</b></p>
            <p>if_not_department_experience_customer: <b>{{ $user->profile->if_not_department_experience_customer }}</b></p>
            <p>if_not_department_experience_sponsorship: <b>{{ $user->profile->if_not_department_experience_sponsorship }}</b></p>
            <p>if_not_department_experience_high_level_business_development: <b>{{ $user->profile->if_not_department_experience_high_level_business_development }}</b></p>
            <p>if_not_department_experience_marketing: <b>{{ $user->profile->if_not_department_experience_marketing }}</b></p>
            <p>if_not_department_experience_analytics: <b>{{ $user->profile->if_not_department_experience_analytics }}</b></p>
            <p>if_not_department_experience_bi: <b>{{ $user->profile->if_not_department_experience_bi }}</b></p>
            <p>if_not_department_experience_database: <b>{{ $user->profile->if_not_department_experience_database }}</b></p>
            <p>if_not_department_experience_digital: <b>{{ $user->profile->if_not_department_experience_digital }}</b></p>
            <p>if_not_department_experience_web_design: <b>{{ $user->profile->if_not_department_experience_web_design }}</b></p>
            <p>if_not_department_experience_social_media: <b>{{ $user->profile->if_not_department_experience_social_media }}</b></p>
            <p>if_not_department_experience_hr: <b>{{ $user->profile->if_not_department_experience_hr }}</b></p>
            <p>if_not_department_experience_finance: <b>{{ $user->profile->if_not_department_experience_finance }}</b></p>
            <p>if_not_department_experience_accounting: <b>{{ $user->profile->if_not_department_experience_accounting }}</b></p>
            <p>if_not_department_experience_organizational_development: <b>{{ $user->profile->if_not_department_experience_organizational_development }}</b></p>
            <p>if_not_department_experience_communications: <b>{{ $user->profile->if_not_department_experience_communications }}</b></p>
            <p>if_not_department_experience_pr: <b>{{ $user->profile->if_not_department_experience_pr }}</b></p>
            <p>if_not_department_experience_media_relations: <b>{{ $user->profile->if_not_department_experience_media_relations }}</b></p>
            <p>if_not_department_experience_legal: <b>{{ $user->profile->if_not_department_experience_legal }}</b></p>
            <p>if_not_department_experience_it: <b>{{ $user->profile->if_not_department_experience_it }}</b></p>
            <p>if_not_department_experience_other: <b>{{ $user->profile->if_not_department_experience_other }}</b></p>
            <p>resume_url: <b>{{ $user->profile->resume_url }}</b></p>
            <p>education_level: <b>{{ $user->profile->education_level }}</b></p>
            <p>college: <b>{{ $user->profile->college }}</b></p>
            <p>graduation_year: <b>{{ $user->profile->graduation_year }}</b></p>
            <p>gpa: <b>{{ $user->profile->gpa }}</b></p>
            <p>college_organizations: <b>{{ $user->profile->college_organizations }}</b></p>
            <p>college_sports_clubs: <b>{{ $user->profile->college_sports_clubs }}</b></p>
            <p>has_school_plans: <b>{{ $user->profile->has_school_plans }}</b></p>
            <p>email_preference_entry_job: <b>{{ $user->profile->email_preference_entry_job }}</b></p>
            <p>email_preference_new_job: <b>{{ $user->profile->email_preference_new_job }}</b></p>
            <p>email_preference_ticket_sales: <b>{{ $user->profile->email_preference_ticket_sales }}</b></p>
            <p>email_preference_leadership: <b>{{ $user->profile->email_preference_leadership }}</b></p>
            <p>email_preference_best_practices: <b>{{ $user->profile->email_preference_best_practices }}</b></p>
            <p>email_preference_career_advice: <b>{{ $user->profile->email_preference_career_advice }}</b></p>
        </div>
    </div>
</div>
@endsection
