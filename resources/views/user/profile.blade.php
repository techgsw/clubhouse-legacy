<!-- /resources/views/user/profile.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Profile')
@section('content')
<div class="container">
    @component('user.header', ['user' => $user])
        @include('user.components.actions')
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        <li class="tab"><a class="" href="/user/{{ $user->id }}/account">Account</a></li>
        @can ('view-contact')
            <li class="tab"><a href="/contact/{{ $user->contact->id }}">Contact</a></li>
        @endcan
        @can ('view-mentor')
            @if ($user->contact->mentor)
                <li class="tab"><a href="/contact/{{ $user->contact->id }}/mentor">Mentor</a></li>
            @endif
        @endcan
        <li class="tab"><a class="active" href="/user/{{ $user->id }}/profile">Profile</a></li>
        <li class="tab"><a href="/user/{{ $user->id }}/jobs">My Jobs</a></li>
        <!--<li class="tab"><a href="/user/{{ $user->id }}/questions">Q&A</a></li>-->
        @can ('create-job')
            <li class="tab"><a class="" href="/user/{{ $user->id }}/job-postings">Job Postings</a></li>
        @endcan
        @can ('edit-roles')
            <li class="tab"><a href='/admin/{{ $user->id }}/edit-roles'>Roles</a></li>
        @endcan
    </ul>
    <div class="row">
        <div class="col s12">
            <p>Account Created: {{$user->created_at->format('n/j/Y')}}</p>
            <p>Last Login: {{is_null($user->last_login_at) ? '' : $user->last_login_at->format('n/j/Y')}}</p>
            <p>Last Profile Update: {{ $user->profile->updated_at->format('n/j/Y') }}</p>
        </div>
        <div class="col s12">
            @if ($user->profile->address[0] && ($user->profile->address[0]->city || $user->profile->address[0]->state))
                <p>Lives in <b>{{ $user->profile->address[0]->city}}, {{$user->profile->address[0]->state}}</b>.</p>
            @endif
            @if ($user->profile->job_seeking_status)
                @if ($user->profile->job_seeking_status == 'unemployed')
                    <p>Is currently <b>unemployed, actively seeking a new job</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_active')
                    <p>Is currently <b>employed, actively seeking a new job</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_passive')
                    <p>Is currently <b>employed, passively exploring new opportunities</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_future')
                    <p>Is currently <b>employed, only open to future opportunities</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_not')
                    <p>Is currently <b>employed, currently have my dream job</b>.</p>
                @endif
            @endif
            @if ($user->profile->job_seeking_region)
                @if ($user->profile->job_seeking_region == 'mw')
                    <p>Wants to work in the <b>Midwest</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'ne')
                    <p>Wants to work in the <b>Northeast</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'nw')
                    <p>Wants to work in the <b>Northwest</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'se')
                    <p>Wants to work in the <b>Southeast</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'sw')
                    <p>Wants to work in the <b>Southwest</b>.</p>
                @endif
            @endif
            @if ($user->profile->job_seeking_type)
                @if ($user->profile->job_seeking_type == 'internship')
                    <p>Next career step is <b>an internship</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'entry_level')
                    <p>Next career step is <b>an entry-level position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'mid_level')
                    <p>Next career step is <b>a mid-level position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'entry_level_management')
                    <p>Next career step is <b>an entry-level management position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'mid_level_management')
                    <p>Next career step is <b>a mid-level management position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'executive')
                    <p>Next career step is <b>an executive position</b>.</p>
                @endif
            @endif
            @if (count($department_goals) > 0)
                <p>Is interested in the following departments:
                    <ul>
                        @foreach ($department_goals as $d)
                            <li style="list-style: inside;"><b>{{$d}}</b></li>
                        @endforeach
                    </ul>
                </p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Employment History</h4>
            @if ($user->profile->current_organization || $user->profile->current_title || count($department_experience) > 0)
                @if ($user->profile->current_organization)
                    <p>Currently works for <b>{{$user->profile->current_organization}}</b>.
                    @if ($user->profile->current_organization_years)
                        Has been with the organization for
                        @if ($user->profile->current_organization_years == 'less_1')
                            <b>less than 1 year</b>.
                        @endif
                        @if ($user->profile->current_organization_years == '1_to_3')
                            <b>1 to 3 years</b>.
                        @endif
                        @if ($user->profile->current_organization_years == '3_to_6')
                            <b>3 to 6 years</b>.
                        @endif
                        @if ($user->profile->current_organization_years == '6_more')
                            <b>more than 6 years</b>.
                        @endif
                    @endif
                    </p>
                @endif
                @if ($user->profile->current_title)
                    <p>Current title is <b>{{$user->profile->current_title}}</b>.
                    @if ($user->profile->current_title_years)
                        Has had that title for
                        @if ($user->profile->current_title_years == 'less_1')
                            <b>less than 1 year</b>.
                        @endif
                        @if ($user->profile->current_title_years == '1_to_3')
                            <b>1 to 3 years</b>.
                        @endif
                        @if ($user->profile->current_title_years == '3_to_6')
                            <b>3 to 6 years</b>.
                        @endif
                        @if ($user->profile->current_title_years == '6_more')
                            <b>more than 6 years</b>.
                        @endif
                    @endif
                    </p>
                @endif
                @if (count($department_experience) > 0)
                    <p>Has work experience in the following departments:
                        <ul>
                            @foreach ($department_experience as $d)
                                <li style="list-style: inside;"><b>{{$d}}</b></li>
                            @endforeach
                        </ul>
                    </p>
                @endif
            @else
                @can ('edit-profile', $user)
                    <div class="input-field">
                        <p>Tell us more about your <a href="/user/{{ $user->id }}/edit-profile">employment history</a>!</p>
                    </div>
                @endcan
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Educational History</h4>
            @if ($user->profile->education_level || $user->profile->college_name || $user->profile->has_school_plans)
                @if ($user->profile->education_level)
                    @if ($user->profile->education_level == 'high_school')
                        <p>Has completed <b>high school</b>.</p>
                    @endif
                    @if ($user->profile->education_level == 'associate')
                        <p>Has completed <b>an associate's degree</b>.</p>
                    @endif
                    @if ($user->profile->education_level == 'bachelor')
                        <p>Has completed <b>a bachelor's degree</b>.</p>
                    @endif
                    @if ($user->profile->education_level == 'master')
                        <p>Has completed <b>a master's degree</b>.</p>
                    @endif
                    @if ($user->profile->education_level == 'doctor')
                        <p>Has completed <b>a doctorate</b>.</p>
                    @endif
                @endif
                @if ($user->profile->college_name)
                    @if ($user->profile->college_graduation_year)
                        <p>
                        @php
                            $today = new \DateTime('NOW');
                            $year = (int)$today->format('Y');
                        @endphp
                        @if ($user->profile->college_graduation_year > $year)
                            Plans to graduate from
                        @else
                            Graduated from
                        @endif
                            <b>{{$user->profile->college_name}}</b> in <b>{{$user->profile->college_graduation_year}}</b>
                        </p>
                    @else
                        <p>Attends {{$user->profile->college_name}}.</p>
                    @endif
                @endif
                @if ($user->profile->has_school_plans)
                    <p>Has plans to continue education.
                @endif
            @else
                @can ('edit-profile', $user)
                    <div class="input-field">
                        <p>Tell us more about your <a href="/user/{{ $user->id }}/edit-profile">educational history</a>!</p>
                    </div>
                @endcan
            @endif
        </div>
    </div>
</div>
@can ('edit-profile', $user)
@include('components.contact-notes-modal')
@include('components.inquiry-notes-modal')
@include('components.contact-job-notes-modal')
@component('components.job-contact-assign-modal')@endcomponent
@endcan
@endsection
