<!-- /resources/views/user/profile/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="container">
    @component('components.user-header', ['user' => $user])
        <div class="hide-on-small-only" style="padding-top: 24px;"></div>
        @if ($user->profile->resume_url)
            <a href="{{ Storage::disk('local')->url($user->profile->resume_url) }}" class="btn sbs-red white-text">View Resume</a>
        @else
            <a href="#" class="btn disabled">No Resume</a>
        @endif
        @can ('edit-profile', $user)
            <a href="/user/{{ $user->id }}/edit-profile" class="btn sbs-red">Edit<span class="hide-on-small-only"> Profile</span></a>
        @endcan
    @endcomponent
    <div class="row">
        <div class="col s12">
            @if ($user->address && ($user->address->city || $user->address->state))
                <p>Lives in <b>{{ $user->address->city}}, {{$user->address->state}}</b>.</p>
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
                        <a href="/user/{{ $user->id }}/edit-profile" class="btn sbs-red">Tell us about your employment history!</a>
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
                        <a href="/user/{{ $user->id }}/edit-profile" class="btn sbs-red">Tell us about your educational history!</a>
                    </div>
                @endcan
            @endif
        </div>
    </div>
</div>
<div class="profile-notes-modal modal modal-large modal-fixed-footer">
    <div class="modal-content"></div>
    <div class="modal-footer" style="height: auto;">
        <div class="row">
            <div class="input-field col s12">
                <form method="post">
                    <textarea id="note" name="note" placeholder="New note"></textarea>
                    <button type="submit" name="save" class="btn sbs-red">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style media="screen">
    textarea#note {
        padding: 8px 12px;
        border: 1px solid #DDD !important;
        height: auto;
        border-radius: 4px;
    }
    textarea#note:focus {
        outline: none;
        border: 1px solid #AAA !important;
        box-shadow: none !important;
    }
</style>
@endsection
