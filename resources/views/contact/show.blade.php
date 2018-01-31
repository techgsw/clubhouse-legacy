<!-- /resources/views/conatct/show.blade.php -->
@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container">
    @component('contact.header', ['contact' => $contact])
        @if ($contact->user)
            @can ('view-profile-notes')
                <button type="button" class="view-profile-notes-btn flat-button black" user-id="{{ $contact->user->id }}">{{ $contact->user->noteCount() }} <i class="fa fa-comments"></i></button>
            @endif
        @endif
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @can ('view-profile-notes')
            <li class="tab"><a class="active" href="/contact/{{ $contact->id }}">Contact</a></li>
        @endcan
        @if ($contact->user)
            <li class="tab"><a href="/user/{{ $contact->user->id }}/profile">Profile</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/jobs">Jobs</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/questions">Q&A</a></li>
        @endif
    </ul>
    <div class="row">
        <div class="col s12">
            <h6>TO DO</h6>
        </div>
    </div>
</div>
@include('components.profile-notes-modal')
@endsection
