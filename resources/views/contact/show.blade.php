<!-- /resources/views/contact/show.blade.php -->
@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container">
    @component('contact.header', ['contact' => $contact])
        @can ('view-contact-notes')
            <button type="button" class="view-contact-notes-btn flat-button black" contact-id="{{ $contact->id }}">{{ $contact->getNoteCount() }} <i class="fa fa-comments"></i></button>
        @endif
        @if ($contact->user)
            @if ($contact->user->profile->resume_url)
                <a href="{{ Storage::disk('local')->url($contact->user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
            @else
                <a href="#" class="flat-button black disabled">No Resume</a>
            @endif
            @can ('edit-profile', $contact->user)
                <a href="/user/{{ $contact->user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
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
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $contact->title }}">
                    </td>
                    <td>
                        @if ($contact->user && $contact->user->profile->current_title)
                            <button class="flat-button small green" style="margin-right: 10px;" type="button" name="button"><i class="fa fa-caret-left icon-left"></i>Accept</button>{{ $contact->user->profile->current_title }}
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
@endsection
