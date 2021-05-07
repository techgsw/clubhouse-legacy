<!-- /resources/views/contact/jobs.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Job Applications')
@section('content')
<div class="container">
    @component('contact.header', ['contact' => $contact])
        @can ('view-contact-notes')
            <button type="button" class="view-contact-notes-btn flat-button black small"
                contact-id="{{ $contact->id }}"
                contact-name="{{ $contact->getName() }}"
                contact-follow-up="{{ $contact->follow_up_date ? $contact->follow_up_date->format('Y-m-d') : '' }}">
                {{ $contact->getNoteCount() }} <i class="fa fa-comments"></i>
            </button>
        @endif
        @can ('edit-inquiry')
            <button class="view-contact-job-assignment-btn flat-button small" contact-id="{{ $contact->id }}"><i class="fa fa-id-card"></i> Assign to job</button>
            @if ($contact->do_not_contact)
                <button type="button" class="flat-button small red" disabled>Do not contact</button>
            @endif
        @endcan
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @if ($contact->user)
            <li class="tab"><a class="" href="/user/{{ $contact->user->id }}/account">Account</a></li>
        @endif
        @can ('view-contact')
            <li class="tab"><a href="/contact/{{ $contact->id }}">Contact</a></li>
        @endcan
        @if ($contact->user)
            <li class="tab"><a href="/user/{{ $contact->user->id }}/profile">Profile</a></li>
            <li class="tab"><a class="active" href="/user/{{ $contact->user->id }}/jobs">My Jobs</a></li>
        @else
            <li class="tab"><a class="active" href="/contact/{{ $contact->id }}/jobs">My Jobs</a></li>
        @endif
        @can ('view-mentor')
            @if ($contact->mentor)
                <li class="tab"><a href="/contact/{{ $contact->id }}/mentor">Mentor</a></li>
            @endif
        @endcan
    </ul>
    @can ('view-contact')
    <div class="row">
        <div class="col s12">
            @if (count($contact->jobs))
                <h5>Job Assignments</h5>
                @foreach ($contact->jobs as $job)
                    @include('components.user-inquiry-list-item', ['inquiry' => $job, 'user' => $contact, 'job_pipeline' => $job_pipeline])
                @endforeach
            @endif
        </div>
    </div>
    @endcan
</div>
@include('components.contact-notes-modal')
@include('components.contact-job-notes-modal')
@component('components.inquiry-job-contact-negative-modal')@endcomponent
@component('components.job-contact-assign-modal')
@endcomponent
@endsection
