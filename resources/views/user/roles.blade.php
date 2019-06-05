<!-- /resources/views/user/jobs.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Edit Roles')
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
        @can ('edit-profile', $user)
            <button class="view-contact-job-assignment-btn flat-button" contact-id="{{ $user->contact->id }}"><i class="fa fa-id-card"></i> Assign to job</button>
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
        @can ('create-job')
            <li class="tab"><a class="" href="/admin/{{ $user->id }}/job-postings">Job Postings</a></li>
        @endcan
        @can ('edit-roles')
            <li class="tab"><a class="active" href='/admin/{{ $user->id }}/edit-roles'>Roles</a></li>
        @endcan
    </ul>
    <form method="post" action="update-roles">
        {{ csrf_field() }}
        <div class="card-flex-container">
            @foreach($roles as $role)
                <div class="card large">
                    <div class="card-content">
                        <span class="card-title" style="font-size: 20px;">{{ ucwords($role->code) }}</span>                        
                        <div>
                        @if ($user->roles->contains($role))
                            <input type="checkbox" name="user[{{$user->id}}][{{$role->code}}]" id="user[{{$user->id}}][{{$role->code}}]" checked="checked" />
                        @else
                            <input type="checkbox" name="user[{{$user->id}}][{{$role->code}}]" id="user[{{$user->id}}][{{$role->code}}]" />
                        @endif
                            <label for="user[{{$user->id}}][{{$role->code}}]">{{ $role->description }}</label>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card-placeholder large"></div>
            <div class="card-placeholder large"></div>
            <div class="card-placeholder large"></div>
            <div class="card-placeholder large"></div>
            <div class="card-placeholder large"></div>
            <div class="card-placeholder large"></div>
        </div>
        <div class="input-field">
            <button type="submit" class="btn sbs-red submit-roles">Save</button>
        </div>
    </form>
</div>
@endsection
