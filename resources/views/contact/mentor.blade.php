<!-- /resources/views/contact/mentor.blade.php -->
@extends('layouts.default')
@section('title', 'Mentor')
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
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @can ('view-contact')
            <li class="tab"><a href="/contact/{{ $contact->id }}">Contact</a></li>
        @endcan
        @can ('view-mentor')
            @if ($contact->mentor)
                <li class="tab"><a class="active" href="/contact/{{ $contact->id }}/mentor">Mentor</a></li>
            @endif
        @endcan
        @if ($contact->user)
            <li class="tab"><a href="/user/{{ $contact->user->id }}/profile">Profile</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/jobs">Jobs</a></li>
            <li class="tab"><a href="/user/{{ $contact->user->id }}/questions">Q&A</a></li>
        @endif
    </ul>
    @include('mentor.forms.tag', ['mentor' => $contact->mentor])
    <form class="compact" action="/mentor/{{ $contact->mentor->id }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" id="mentor-tags-json" name="mentor_tags_json" value="{{ old('mentor_tags_json') ?: $mentor_tags_json }}">
        <div class="row">
            <div class="col s12 input-field">
                <textarea id="description" class="materialize-textarea" name="description">{{ old('description') ?: $contact->mentor->description }}</textarea>
                <label for="description">Description</label>
            </div>
            <div class="input-field col s12">
                <p>
                    <input type="checkbox" name="active" id="active" value="1" {{ is_null(old('active')) ? ($contact->mentor->active ? "checked" : "") : (old('active') ? "checked" : "") }} />
                    <label for="active">Active mentor</label>
                </p>
            </div>
            <div class="col s12 input-field">
                <button type="submit" class="btn sbs-red">Save</button>
            </div>
        </div>
    </form>
</div>
@include('components.pdf-view-modal')
@endsection
