<!-- /resources/views/contact/show.blade.php -->
@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container">
    @component('contact.header', ['contact' => $contact])
        @can ('view-contact-notes')
            <button type="button" class="view-contact-notes-btn flat-button black small" contact-id="{{ $contact->id }}">{{ $contact->getNoteCount() }} <i class="fa fa-comments"></i></button>
        @endif
        @if ($contact->user)
            @include('components.resume-button', ['url' => $contact->user->profile->resume_url ?: null])
            @can ('edit-profile', $contact->user)
                <a href="/user/{{ $contact->user->id }}/edit-profile" class="flat-button black small">Edit<span class="hide-on-small-only"> Profile</span></a>
            @endcan
        @endif
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @can ('view-contact')
            <li class="tab"><a class="active" href="/contact/{{ $contact->id }}">Contact</a></li>
        @endcan
        @if ($contact->user)
            <li class="tab"><a href="/user/{{ $contact->user->id }}/profile">Profile</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/jobs">Jobs</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/questions">Q&A</a></li>
        @endif
    </ul>
    @can ('add-contact-relationship')
        <form id="create-contact-relationship" action="/contact/refer" method="post" class="compact">
            {{ csrf_field() }}
            <input type="hidden" id="contact_id" value="{{ $contact->id }}" />
            <div class="row">
                <div class="col">
                    <label>Ownership</label>
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
    <form class="compact" action="/contact/{{ $contact->id }}" method="post">
        {{ csrf_field() }}
        <table class="compact">
            <tbody>
                <tr>
                    <td>
                        <label>Resume</label>
                        <div>
                            @component('components.resume-button', ['url' => $contact->resume_url ?: null])@endcomponent
                            <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-upload icon-left"></i>Upload</button>
                        </div>
                    </td>
                    <td>
                        @if ($contact->user && $contact->user->profile->job_seeking_type)
                            <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>
                            @component('components.resume-button', ['url' => $contact->user->profile ? $contact->user->profile->resume_url : null])@endcomponent
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $contact->title }}">
                    </td>
                    <td>
                        @if ($contact->user && $contact->user->profile->current_title)
                            @if ($contact->user->profile->current_title != $contact->title)
                                <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->current_title }}
                            @endif
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Organization</label>
                        <input type="text" name="organization" value="{{ $contact->organization }}">
                    </td>
                    <td>
                        @if ($contact->user && $contact->user->profile->current_organization)
                            <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->current_organization }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Job-seeking status</label>
                        <select class="browser-default" name="job_seeking_status">
                            <option value="" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "" ? "selected" : "") : (old("job_seeking_status") == "" ? "selected" : "") }} disabled>Please select</option>
                            <option value="unemployed" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "unemployed" ? "selected" : "") : (old("job_seeking_status") == "unemployed" ? "selected" : "") }}>Unemployed, actively seeking a new job</option>
                            <option value="employed_active" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_active" ? "selected" : "") : (old("job_seeking_status") == "employed_active" ? "selected" : "") }}>Employed, actively seeking a new job</option>
                            <option value="employed_passive" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_passive" ? "selected" : "") : (old("job_seeking_status") == "employed_passive" ? "selected" : "") }}>Employed, passively exploring new opportunities</option>
                            <option value="employed_future" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_future" ? "selected" : "") : (old("job_seeking_status") == "employed_future" ? "selected" : "") }}>Employed, only open to future opportunities</option>
                            <option value="employed_not" {{ is_null(old('job_seeking_status')) ? ($contact->job_seeking_status == "employed_not" ? "selected" : "") : (old("job_seeking_status") == "employed_not" ? "selected" : "") }}>Employed, currently have my dream job</option>
                        </select>
                    </td>
                    <td>
                        @if ($contact->user && $contact->user->profile->job_seeking_status)
                            <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->job_seeking_status }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Job-seeking type</label>
                        <select class="browser-default" name="job_seeking_type">
                            <option value="" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "" ? "selected" : "") : (old("job_seeking_type") == "" ? "selected" : "") }} disabled>Please select</option>
                            <option value="internship" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "internship" ? "selected" : "") : (old("job_seeking_type") == "internship" ? "selected" : "") }}>Internship</option>
                            <option value="entry_level" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "entry_level" ? "selected" : "") : (old("job_seeking_type") == "entry_level" ? "selected" : "") }}>Entry-level</option>
                            <option value="mid_level" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "mid_level" ? "selected" : "") : (old("job_seeking_type") == "mid_level" ? "selected" : "") }}>Mid-level</option>
                            <option value="entry_level_management" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "entry_level_management" ? "selected" : "") : (old("job_seeking_type") == "entry_level-managment" ? "selected" : "") }}>Entry-level management</option>
                            <option value="mid_level_management" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "mid_level_management" ? "selected" : "") : (old("job_seeking_type") == "mid_level-managment" ? "selected" : "") }}>Mid-level management</option>
                            <option value="executive" {{ is_null(old('job_seeking_type')) ? ($contact->job_seeking_type == "executive" ? "selected" : "") : (old("job_seeking_type") == "executive" ? "selected" : "") }}>Executive team</option>
                        </select>
                    </td>
                    <td>
                        @if ($contact->user && $contact->user->profile->job_seeking_type)
                            <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->job_seeking_type }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row" style="padding: 5px;">
            <div class="col s12">
                <label for="line1">Street address</label>
                <input id="line1" name="line1" type="text" value="{{ old('line1') ?: $contact->address->line1 ?: "" }}">
            </div>
            <div class="col s12">
                <label for="line2">Line 2</label>
                <input id="line2" name="line2" type="text" value="{{ old('line2') ?: $contact->address->line2 ?: "" }}">
            </div>
            <div class="col s12 m4">
                <label for="city">City</label>
                <input id="city" name="city" type="text" value="{{ old('city') ?: $contact->address->city ?: "" }}">
            </div>
            <div class="col s12 m2">
                <label for="state">State/Province</label>
                <input id="state" name="state" type="text" value="{{ old('state') ?: $contact->address->state ?: "" }}">
            </div>
            <div class="col s12 m3">
                <label for="postal_code">Postal code</label>
                <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') ?: $contact->address->postal_code ?: "" }}">
            </div>
            <div class="col s12 m3">
                <label for="country">Country</label>
                <input id="country" name="country" type="text" value="{{ old('country') ?: $contact->address->country ?: "" }}">
            </div>
        </div>
        <button type="submit" class="btn sbs-red">Save</button>
        <button type="submit" class="btn green">Accept all from profile</button>
    </form>
    @can ('view-contact-notes')
        <div class="contact-notes-container" style="max-height: 300px; overflow-y: scroll; margin-bottom: 20px; padding:0px;">
            @if (count($notes) == 0)
                <div class="row">
                    <div class="col s12">
                        <p style="font-style: italic;">No notes</p>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col s12">
                        @foreach ($notes as $note)
                            <p style="padding: 8px 12px; border-radius: 4px; background: #F5F5F5; margin: 0px 2px;">
                                @if ($note->job_title)
                                    <a target="_blank" href="/job/{{ $note->job_id }}" class="no-underline" style="display: block; margin-bottom: 10px; padding-bottom: 4px; font-size: 10px; text-transform: uppercase; border-bottom: 1px dashed #ccc;"><b>{{ $note->job_organization }}</b> {{ $note->job_title }}</a>
                                @endif
                                {!! nl2br($note->content) !!}
                            </p>
                            <p style="margin: 0px 0px 12px 0px; padding: 4px 6px; color: #666; font-size: 10px; text-transform: uppercase; text-align: right;">{{ $note->user->getName() }} {{ $note->created_at->format('m/d/Y') }}</p>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="input-field col s12" style="margin-top: 0; margin-bottom: 30px;">
            <form id="create-contact-note" method="post">
                {{ csrf_field() }}
                <textarea id="note" name="note" placeholder="New note"></textarea>
                <input type="hidden" name="contact_id" value="{{ $contact->id }}" />
                <button type="button" name="save" class="btn sbs-red submit-contact-note-btn">Submit</button>
            </form>
        </div>
    @endcan
</div>
@include('components.contact-notes-modal')
@include('components.pdf-view-modal')
@endsection
