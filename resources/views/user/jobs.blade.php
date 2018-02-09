<!-- /resources/views/user/jobs.blade.php -->
@extends('layouts.default')
@section('title', 'Job Applications')
@section('content')
<div class="container">
    @component('contact.header', ['contact' => $user->contact])
        @can ('view-contact-notes')
            <button type="button" class="view-contact-notes-btn flat-button black" contact-id="{{ $user->contact->id }}">{{ $user->contact->getNoteCount() }} <i class="fa fa-comments"></i></button>
        @endif
        @if ($user->profile->resume_url)
            <a href="{{ Storage::disk('local')->url($user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
        @else
            <a href="#" class="flat-button black disabled">No Resume</a>
        @endif
        @can ('edit-profile', $user)
            <a href="/user/{{ $user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
        @endcan
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @can ('view-contact')
            <li class="tab"><a href="/contact/{{ $user->contact->id }}">Contact</a></li>
        @endcan
        <li class="tab"><a href="/user/{{ $user->id }}/profile">Profile</a></li>
        <li class="tab"><a class="active" href="/user/{{ $user->id }}/jobs">Jobs</a></li>
        <li class="tab"><a href="/user/{{ $user->id }}/questions">Q&A</a></li>
    </ul>
    <div class="row">
        <div class="col s12">
            @if (count($user->inquiries))
                @foreach ($user->inquiries as $inquiry)
                    @include('components.user-inquiry-list-item', ['inquiry' => $inquiry, 'user' => $user])
                @endforeach
            @else
                <p>When you apply for jobs on the <a href="/job">Job Board</a>, those jobs will appear here.</p>
            @endif
        </div>
    </div>
</div>
@include('components.contact-notes-modal')
@include('components.inquiry-notes-modal')
@endsection
