<!-- /resources/views/user/jobs.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Job Applications')
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
        <li class="tab"><a href="/user/{{ $user->id }}/profile">Profile</a></li>
        <li class="tab"><a class="active" href="/user/{{ $user->id }}/jobs">My Jobs</a></li>
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
            @if (count($user->contact->jobs))
                @can ('view-contact')
                    <h5>Job Assignments</h5>
                @endcan
                @foreach ($user->contact->jobs as $job)
                    @if (Gate::allows('view-contact') || $job->job_interest_response_code == 'interested')
                        @include('components.user-inquiry-list-item', ['inquiry' => $job, 'user' => $user, 'job_pipeline' => $job_pipeline])
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @if (count($user->inquiries))
                @can ('view-contact')
                    <h5>Job Applications</h5>
                @endcan
                @foreach ($user->inquiries as $inquiry)
                    @include('components.user-inquiry-list-item', ['inquiry' => $inquiry, 'user' => $user, 'job_pipeline' => $job_pipeline])
                @endforeach
            @else
                <p>When you apply for jobs on the <a href="/job">Job Board</a>, those jobs will appear here.</p>
            @endif
        </div>
    </div>
</div>
@can ('edit-profile', $user)
@include('components.contact-notes-modal')
@include('components.inquiry-notes-modal')
@include('components.contact-job-notes-modal')
@component('components.inquiry-job-contact-negative-modal')@endcomponent
@component('components.job-contact-assign-modal')@endcomponent
@endcan
@endsection
