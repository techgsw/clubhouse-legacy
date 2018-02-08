<!-- /resources/views/user/profile.blade.php -->
@extends('layouts.default')
@section('title', 'Admin')
@section('content')
<div class="container">
    @component('components.user-header', ['user' => $user])
        @can ('view-profile-notes')
            <button type="button" class="view-profile-notes-btn flat-button black" user-id="{{ $user->id }}">{{ $user->getNoteCount() }} <i class="fa fa-comments"></i></button>
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
        <li class="tab"><a href="/user/{{ $user->id }}/profile">Profile</a></li>
        <li class="tab"><a href="/user/{{ $user->id }}/jobs">Jobs</a></li>
        <li class="tab"><a href="/user/{{ $user->id }}/questions">Q&A</a></li>
        @can ('view-profile-notes')
            <li class="tab"><a class="active" href="/user/{{ $user->id }}/admin">Admin</a></li>
        @endcan
    </ul>
    <div class="row">
        <div class="col s12">
            TODO
        </div>
    </div>
</div>
@include('components.profile-notes-modal')
@include('components.inquiry-notes-modal')
@endsection
