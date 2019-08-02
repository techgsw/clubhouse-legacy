@extends('layouts.clubhouse')
@section('title', 'Job Postings')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
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
        <li class="tab"><a href="/user/{{ $user->id }}/jobs">My Jobs</a></li>
        @can('view-job')
            <li class="tab"><a class="active" href="/user/{{ $user->id }}/job-postings">Job Postings</a></li>
        @endcan
        @can ('edit-roles')
            <li class="tab"><a href='/admin/{{ $user->id }}/edit-roles'>Roles</a></li>
        @endcan
    </ul>
    <div class="row" style="margin-bottom: 12px;">
        <div class="col s12">
            @if (count($jobs))
                @foreach ($jobs as $job)
                    @include('components.user-job-list-item', ['job' => $job])
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
