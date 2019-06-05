<!-- /resources/views/user/jobs.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Job Listings')
@section('content')
<div class="container">
    @component('user.header', ['user' => $user])
        @can ('view-contact-notes')
            <button type="button" class="view-contact-notes-btn flat-button black"
                contact-id="{{ $user->contact->id }}"
                contact-name="{{ $user->contact->getName() }}"
                contact-follow-up="{{ $user->contact->follow_up_date ? $user->contact->follow_up_date->format('Y-m-d') : '' }}">
                {{ $user->contact->getNoteCount() }} <i class="fa fa-comments"></i>
            </button>
        @endif
        @if ($user->profile->resume_url)
            <a href="{{ Storage::disk('local')->url($user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
        @else
            <a href="#" class="flat-button black disabled">No Resume</a>
        @endif
        @can ('edit-profile', $user)
            <a href="/user/{{ $user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
        @endcan
        @can ('view-admin-jobs', $user)
            <button class="view-contact-job-assignment-btn flat-button" contact-id="{{ $user->contact->id }}"><i class="fa fa-id-card"></i> Assign to job</button>
        @elsecan ('create-job', $user)
            <a href="/job/create" class="flat-button red"><i class="fa fa-id-card"></i> Create Job Posting</a>
        @endcan
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
        <li class="tab"><a href="/user/{{ $user->id }}/jobs">My Jobs</a></li>
        <!--<li class="tab"><a href="/user/{{ $user->id }}/questions">Q&A</a></li>-->
        @can('view-job')
            <li class="tab"><a class="active" href="/admin/{{ $user->id }}/job-postings">Job Postings</a></li>
        @endcan
        @can ('edit-roles')
            <li class="tab"><a href='/admin/{{ $user->id }}/edit-roles'>Roles</a></li>
        @endcan
    </ul>
    <div class="row" style="margin-bottom: 12px;">
        <div class="col s12">
            @if (count($jobs))
            <div class="row" style="display: flex; flex-flow: row;">
                <h5>Job Listings</h5>
                <!-- <div class="align-self: flex-end;">
                    <a href="/job/create" class="flat-button red">create</a>
                </div> -->
            </div>  
                @foreach ($jobs as $job)
                    @include('components.admin-job-list-item', ['job' => $job])
                @endforeach
            @else
                <p>When you <a href="/job/create">create</a> jobs for the <a href="/job">Job Board</a>, those jobs will appear here.</p>
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
