<!-- /resources/views/contact/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Contact')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    @include('layouts.components.messages')
    @component('contact.header', ['contact' => $contact])
        @if ($contact->user)
            @include('components.resume-button', ['url' => $contact->user->profile->resume_url ?: null])
            @can ('edit-profile', $contact->user)
                <a href="/user/{{ $contact->user->id }}/edit-profile" class="flat-button black small">Edit<span class="hide-on-small-only"> Profile</span></a>
            @endcan
        @endif
        @can ('edit-inquiry')
            <button class="view-contact-job-assignment-btn flat-button small" contact-id="{{ $contact->id }}"><i class="fa fa-id-card"></i> Assign to job</button>
        @endcan
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @if (!is_null($contact->user))
            <li class="tab"><a class="" href="/user/{{ $contact->user->id }}/account">Account</a></li>
        @endif
        @can ('view-contact')
            <li class="tab"><a class="active" href="/contact/{{ $contact->id }}">Contact</a></li>
        @endcan
        @if ($contact->user)
            <li class="tab"><a href="/user/{{ $contact->user->id }}/profile">Profile</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/jobs">Jobs</a></li>
        @else
            <li class="tab"><a href="/contact/{{ $contact->id }}/jobs">Jobs</a></li>
        @endif
        @can ('view-mentor')
            @if ($contact->mentor)
                <li class="tab"><a href="/contact/{{ $contact->id }}/mentor">Mentor</a></li>
            @endif
        @endcan
    </ul>
    @can ('add-contact-relationship')
        <form id="create-contact-relationship" action="/contact/refer" method="post" class="compact">
            {{ csrf_field() }}
            <input type="hidden" id="contact_id" value="{{ $contact->id }}" />
            <div class="row">
                <div class="col">
                    <label>Account ownership</label>
                    <input type="text" id="admin-user-autocomplete-input" class="admin-user-autocomplete compact">
                </div>
                <div class="col contact-user-relationships" style="padding-top: 20px;">
                    @foreach ($contact->relationships as $user)
                        <span class="flat-button gray small tag">
                            <button type="button" name="button" class="x" admin-user-id="{{ $user->id }}">&times;</button>{{ $user->getName() }}
                        </span>
                    @endforeach
                </div>
            </div>
        </form>
    @endcan
    <div style="margin-bottom: 30px;">
        <ul class="collapsible" data-collapsible="accordion">
            @can ('view-contact-notes')
                <li class="form-section">
                    <div id="contact-note-collapsible-header" contact-id="{{ $contact->id }}" class="collapsible-header">
                        <i class="fa fa-comments"></i>{{ $contact->getNoteCount() }} note{{ $contact->getNoteCount() == 1 ? "" : "s"}}
                        @php
                            $last_note = null;
                            if (count($notes) > 0) {
                                $last_note = reset($notes);
                            }
                        @endphp
                        @if ($last_note)
                            <span style="float: right;">{{ $last_note->create_user_name }} {{ $last_note->created_at->format('m/d/Y') }}</span>
                        @endif
                    </div>
                    <div id="contact-note-collapsible-body" class="collapsible-body">
                        <div id="note-progress" class="row hidden" style="height: 149.5px; margin: 0; padding: 40px;">
                            <div class="input-field col s12">
                                <div class="progress">
                                    <div class="indeterminate"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endcan
        </ul>
        <form class="compact" action="/contact/{{ $contact->id }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <ul class="collapsible" data-collapsible="accordion">
                <li class="form-section">
                    <div class="collapsible-header">
                        <i class="material-icons">person</i>Personal
                        @if ($contact->user && $contact->unsyncedInfo($contact->user->profile, 'personal'))
                            <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                        @else
                            <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                        @endif
                        <span class="progress-icon progress-unsaved blue-text text-darken-2 hidden" style="float: right;"><i class="material-icons">save</i></span>
                    </div>
                    <div class="collapsible-body">
                        <div class="row">
                            <div class="col s6">
                                <label>First name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ $contact->first_name }}">
                            </div>
                            <div class="col s6" style="padding-top: 22px;">
                                @if ($contact->user && $contact->user->first_name && $contact->user->first_name != $contact->first_name)
                                    <button class="flat-button small green accept-change-button" target-id="first_name" target-value="{{$contact->user->first_name}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->first_name }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <label>Last name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ $contact->last_name }}">
                            </div>
                            <div class="col s6" style="padding-top: 22px;">
                                @if ($contact->user && $contact->user->last_name && $contact->user->last_name != $contact->last_name)
                                    <button class="flat-button small green accept-change-button" target-id="last_name" target-value="{{$contact->user->last_name}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->last_name }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <label>Email</label>
                                <input type="text" id="email" name="email" value="{{ $contact->email }}">
                            </div>
                            <div class="col s6" style="padding-top: 22px;">
                                @if ($contact->user && $contact->user->email && $contact->user->email != $contact->email)
                                    <button class="flat-button small green accept-change-button" target-id="email" target-value="{{$contact->user->email}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->email }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <label>Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ $contact->phone }}">
                            </div>
                            <div class="col s6" style="padding-top: 22px;">
                                @if ($contact->user && $contact->user->profile->phone && $contact->user->profile->phone != $contact->phone)
                                    <button class="flat-button small green accept-change-button" target-id="email" target-value="{{$contact->user->profile->phone}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->phone }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6 center-align">
                                <div class="file-field input-field very-small">
                                    <div class="btn white black-text">
                                        <span>Headshot</span></span>
                                        <input type="file" name="headshot_url" value="{{ old('headshot_url') }}">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" name="headshot_url_text" value="{{ old('headshot_url_text') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can ('create-mentor')
                            <div class="input-field col s12">
                                <p>
                                    <input type="checkbox" name="mentor" id="mentor" value="1" {{ is_null(old('mentor')) ? ($contact->mentor && $contact->mentor->active ? "checked" : "") : (old('mentor') ? "checked" : "") }} />
                                    <label for="mentor">Mentor</label>
                                </p>
                            </div>
                        @endcan
                    </div>
                </li>
            </ul>
            <ul class="collapsible" data-collapsible="accordion">
                <li class="form-section">
                    <div class="collapsible-header">
                        <i class="material-icons">work</i>Employment
                        @if ($contact->user && $contact->unsyncedInfo($contact->user->profile, 'employment'))
                            <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                        @else
                            <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                        @endif
                    </div>
                    <div class="collapsible-body">
                        <div class="compact">
                            <div class="row">
                                <div class="col s6">
                                    <label>Resume</label>
                                    <div style="display: flex; flex-flow: row;">
                                        @component('components.resume-button', ['url' => $contact->resume_url ?: null])@endcomponent
                                        <div class="file-field input-field" style="margin: 0 0 0 6px;">
                                            <div class="flat-button small green" style="float: left;">
                                                <span>Upload<span class="hide-on-small-only"> Resume</span></span>
                                                <input type="file" name="resume" value="{{ old('resume') }}">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" name="resume_text" style="height: 1.4em; margin-bottom: 0;" value="{{ old('resume_text') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6" style="padding-top: 22px;">
                                    @if ($contact->user && $contact->user->profile->resume_url && $contact->user->profile->resume_url != $contact->resume_url)
                                        @component('components.resume-button', ['url' => $contact->user->profile ? $contact->user->profile->resume_url : null])@endcomponent
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <label>Title</label>
                                    <input type="text" id="title" name="title" value="{{ $contact->title }}">
                                </div>
                                <div class="col s6" style="padding-top: 22px;">
                                    @if ($contact->user && $contact->user->profile->current_title && $contact->user->profile->current_title != $contact->title)
                                        <button class="flat-button small green accept-change-button" target-id="title" target-value="{{$contact->user->profile->current_title}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->current_title }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <label>Organization</label>
                                    <input type="text" id="organization" class="organization-autocomplete" name="organization" value="{{ $contact->organization }}">
                                </div>
                                <div class="col s6" style="padding-top: 22px;">
                                    @if ($contact->user && $contact->user->profile->current_organization && $contact->user->profile->current_organization != $contact->organization)
                                        <button class="flat-button small green accept-change-button" target-id="organization" target-value="{{$contact->user->profile->current_organization}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->current_organization }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <label>Job-seeking status</label>
                                    <select id="job_seeking_status" class="browser-default" name="job_seeking_status">
                                        <option value="" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "" ? "selected" : "") : (old("job_seeking_status") == "" ? "selected" : "") }} disabled>Please select</option>
                                        <option value="unemployed" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "unemployed" ? "selected" : "") : (old("job_seeking_status") == "unemployed" ? "selected" : "") }}>Unemployed, actively seeking a new job</option>
                                        <option value="employed_active" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_active" ? "selected" : "") : (old("job_seeking_status") == "employed_active" ? "selected" : "") }}>Employed, actively seeking a new job</option>
                                        <option value="employed_passive" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_passive" ? "selected" : "") : (old("job_seeking_status") == "employed_passive" ? "selected" : "") }}>Employed, passively exploring new opportunities</option>
                                        <option value="employed_future" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_future" ? "selected" : "") : (old("job_seeking_status") == "employed_future" ? "selected" : "") }}>Employed, only open to future opportunities</option>
                                        <option value="employed_not" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_not" ? "selected" : "") : (old("job_seeking_status") == "employed_not" ? "selected" : "") }}>Employed, currently have my dream job</option>
                                    </select>
                                </div>
                                <div class="col s6" style="padding-top: 22px;">
                                    @if ($contact->user && $contact->user->profile->job_seeking_status && $contact->user->profile->job_seeking_status != $contact->job_seeking_status)
                                        <button class="flat-button small green accept-change-button" target-id="job_seeking_status" target-value="{{$contact->user->profile->job_seeking_status}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->getJobSeekingStatus() }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <label>Job-seeking type</label>
                                    <select id="job_seeking_type" class="browser-default" name="job_seeking_type">
                                        <option value="" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "" ? "selected" : "") : (old("job_seeking_type") == "" ? "selected" : "") }} disabled>Please select</option>
                                        <option value="internship" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "internship" ? "selected" : "") : (old("job_seeking_type") == "internship" ? "selected" : "") }}>Internship</option>
                                        <option value="entry_level" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "entry_level" ? "selected" : "") : (old("job_seeking_type") == "entry_level" ? "selected" : "") }}>Entry-level</option>
                                        <option value="mid_level" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "mid_level" ? "selected" : "") : (old("job_seeking_type") == "mid_level" ? "selected" : "") }}>Mid-level</option>
                                        <option value="entry_level_management" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "entry_level_management" ? "selected" : "") : (old("job_seeking_type") == "entry_level-managment" ? "selected" : "") }}>Entry-level management</option>
                                        <option value="mid_level_management" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "mid_level_management" ? "selected" : "") : (old("job_seeking_type") == "mid_level-managment" ? "selected" : "") }}>Mid-level management</option>
                                        <option value="executive" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "executive" ? "selected" : "") : (old("job_seeking_type") == "executive" ? "selected" : "") }}>Executive team</option>
                                    </select>
                                </div>
                                <div class="col s6" style="padding-top: 22px;">
                                    @if ($contact->user && $contact->user->profile->job_seeking_type && $contact->user->profile->job_seeking_type != $contact->job_seeking_type)
                                        <button class="flat-button small green accept-change-button" target-id="job_seeking_type" target-value="{{$contact->user->profile->job_seeking_type}}" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->getJobSeekingType() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="collapsible" data-collapsible="accordion">
                <li class="form-section">
                    <div class="collapsible-header">
                        <i class="material-icons">home</i>Address
                        @if ($contact->user && $contact->unsyncedInfo($contact->user->profile, 'address'))
                            <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                        @else
                            <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                        @endif
                    </div>
                    <div class="collapsible-body">
                        <div class="row">
                            <div class="col s6">
                                <div class="col s12">
                                    <label for="line1">Street address</label>
                                    <input id="line1" name="line1" type="text" value="{{ old('line1') ?: $contact->address[0]->line1 ?: "" }}">
                                </div>
                                <div class="col s12">
                                    <label for="line2">Line 2</label>
                                    <input id="line2" name="line2" type="text" value="{{ old('line2') ?: $contact->address[0]->line2 ?: "" }}">
                                </div>
                                <div class="col s12">
                                    <label for="city">City</label>
                                    <input id="city" name="city" type="text" value="{{ old('city') ?: $contact->address[0]->city ?: "" }}">
                                </div>
                                <div class="col s12 m4">
                                    <label for="state">State/Province</label>
                                    <input id="state" name="state" type="text" value="{{ old('state') ?: $contact->address[0]->state ?: "" }}">
                                </div>
                                <div class="col s12 m4">
                                    <label for="postal_code">Postal code</label>
                                    <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') ?: $contact->address[0]->postal_code ?: "" }}">
                                </div>
                                <div class="col s12 m4">
                                    <label for="country">Country</label>
                                    <input id="country" name="country" type="text" value="{{ old('country') ?: $contact->address[0]->country ?: "" }}">
                                </div>
                            </div>
                            <div class="col s6">
                                @if ($contact->user && !$contact->address[0]->equals($contact->user->profile->address[0]))
                                    <div class="col s12">
                                        <label for="line1">Street address</label>
                                        <input id="line1" name="line1" type="text" value="{{ $contact->user->profile->address[0]->line1 ?: "" }}">
                                    </div>
                                    <div class="col s12">
                                        <label for="line2">Line 2</label>
                                        <input id="line2" name="line2" type="text" value="{{ $contact->user->profile->address[0]->line2 ?: "" }}">
                                    </div>
                                    <div class="col s12">
                                        <label for="city">City</label>
                                        <input id="city" name="city" type="text" value="{{ $contact->user->profile->address[0]->city ?: "" }}">
                                    </div>
                                    <div class="col s12 m4">
                                        <label for="state">State/Province</label>
                                        <input id="state" name="state" type="text" value="{{ $contact->user->profile->address[0]->state ?: "" }}">
                                    </div>
                                    <div class="col s12 m4">
                                        <label for="postal_code">Postal code</label>
                                        <input id="postal_code" name="postal_code" type="text" value="{{ $contact->user->profile->address[0]->postal_code ?: "" }}">
                                    </div>
                                    <div class="col s12 m4">
                                        <label for="country">Country</label>
                                        <input id="country" name="country" type="text" value="{{ $contact->user->profile->address[0]->country ?: "" }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <button type="submit" class="btn sbs-red">Save</button>
        </form>
    </div>
</div>
@can ('edit-inquiry')
@include('components.pdf-view-modal')
@component('components.job-contact-assign-modal')@endcomponent
@endcan
@endsection
