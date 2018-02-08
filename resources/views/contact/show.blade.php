<!-- /resources/views/conatct/show.blade.php -->
@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container">
    @component('contact.header', ['contact' => $contact])
        @can ('view-profile-notes')
            <button class="view-contact-notes-btn flat-button black" contact-id="{{ $contact->id }}">{{ $contact->getNoteCount() }} <i class="fa fa-comments"></i></button>
        @endif
        @if ($contact->user->profile->resume_url)
            <a href="{{ Storage::disk('local')->url($contact->user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
        @else
            <a href="#" class="flat-button black disabled">No Resume</a>
        @endif
        @can ('edit-profile', $contact->user)
            <a href="/user/{{ $contact->user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
        @endcan
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
    @if ($contact->user)
            <div class="row">
                <div class="col s12">
                    <div class="tag-cloud">
                        @foreach ($contact->getUsers as $user)
                            <a href="/user/{{ $user->id }}/profile" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $user->getName() }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="input-field col s12">
                <form id="create-contact-note" method="post">
                    {{ csrf_field() }}
                    <textarea id="note" name="note" placeholder="New note"></textarea>
                    <input type="hidden" name="contact_id" value="{{ $contact->id }}" />
                    <button type="button" name="save" class="btn sbs-red submit-contact-note-btn">Save</button>
                </form>
            </div>
        @can ('view-profile-notes')
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
        @endif
    @endif
</div>
@include('components.profile-notes-modal')
@endsection
