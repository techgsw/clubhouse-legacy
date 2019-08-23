<!-- /resources/views/contact/mentor.blade.php -->
@extends('layouts.clubhouse')
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
            <li class="tab"><a href="/user/{{ $contact->user->id }}/jobs">My Jobs</a></li>
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
        </div>
        <div class="row">
            <div class="input-field col s12 m8">
                <label for="timezone" class="active">Timezone</label>
                <select class="browser-default" name="timezone">
                	<option value="">-</option>
                    <option value="hst" {{ old('timezone') == 'hst' ? 'selected' : $contact->mentor->timezone == 'hst' ? 'selected' : '' }}>Hawaii (GMT-10:00)</option>
                	<option value="akdt" {{ old('timezone') == 'akdt' ? 'selected' : $contact->mentor->timezone == 'akdt' ? 'selected' : '' }}>Alaska (GMT-09:00)</option>
                	<option value="pst" {{ old('timezone') == 'pst' ? 'selected' : $contact->mentor->timezone == 'pst' ? 'selected' : '' }}>Pacific Time (US & Canada) (GMT-08:00)</option>
                	<option value="azt" {{ old('timezone') == 'azt' ? 'selected' : $contact->mentor->timezone == 'azt' ? 'selected' : '' }}>Arizona (GMT-07:00)</option>
                	<option value="mst" {{ old('timezone') == 'mst' ? 'selected' : $contact->mentor->timezone == 'mst' ? 'selected' : '' }}>Mountain Time (US & Canada) (GMT-07:00)</option>
                	<option value="cdt" {{ old('timezone') == 'cdt' ? 'selected' : $contact->mentor->timezone == 'cdt' ? 'selected' : '' }}>Central Time (US & Canada) (GMT-06:00)</option>
                	<option value="est" {{ old('timezone') == 'est' ? 'selected' : $contact->mentor->timezone == 'est' ? 'selected' : '' }}>Eastern Time (US & Canada) (GMT-05:00)</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <label for="timezone" class="active">Preferred meeting times</label>
            </div>
        </div>
        <div class="row">
            <div class="col s6 m4">
                <select id="day_preference_1" name="day_preference_1" class="browser-default">
                    <option value="">-</option>
                    <option value="monday" {{ old('day_preference_1') == 'monday' ? 'selected' : $contact->mentor->day_preference_1 == 'monday' ? 'selected' : '' }}>Monday</option>
                    <option value="tuesday" {{ old('day_preference_1') == 'tuesday' ? 'selected' : $contact->mentor->day_preference_1 == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                    <option value="wednesday" {{ old('day_preference_1') == 'wednesday' ? 'selected' : $contact->mentor->day_preference_1 == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="thursday" {{ old('day_preference_1') == 'thursday' ? 'selected' : $contact->mentor->day_preference_1 == 'thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="friday" {{ old('day_preference_1') == 'friday' ? 'selected' : $contact->mentor->day_preference_1 == 'friday' ? 'selected' : '' }}>Friday</option>
                </select>
            </div>
            <div class="col s6 m4">
                <select id="time_preference_1" name="time_preference_1" class="browser-default">
                    <option value="">-</option>
                    <option value="morning" {{ old('time_preference_1') == 'morning' ? 'selected' : $contact->mentor->time_preference_1 == 'morning' ? 'selected' : '' }}>Morning</option>
                    <option value="afternoon" {{ old('time_preference_1') == 'afternoon' ? 'selected' : $contact->mentor->time_preference_1 == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                    <option value="evening" {{ old('time_preference_1') == 'evening' ? 'selected' : $contact->mentor->time_preference_1 == 'evening' ? 'selected' : '' }}>Evening</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s6 m4">
                <select id="day_preference_2" name="day_preference_2" class="browser-default">
                    <option value="">-</option>
                    <option value="monday" {{ old('day_preference_2') == 'monday' ? 'selected' : $contact->mentor->day_preference_2 == 'monday' ? 'selected' : '' }}>Monday</option>
                    <option value="tuesday" {{ old('day_preference_2') == 'tuesday' ? 'selected' : $contact->mentor->day_preference_2 == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                    <option value="wednesday" {{ old('day_preference_2') == 'wednesday' ? 'selected' : $contact->mentor->day_preference_2 == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="thursday" {{ old('day_preference_2') == 'thursday' ? 'selected' : $contact->mentor->day_preference_2 == 'thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="friday" {{ old('day_preference_2') == 'friday' ? 'selected' : $contact->mentor->day_preference_2 == 'friday' ? 'selected' : '' }}>Friday</option>
                </select>
            </div>
            <div class="col s6 m4">
                <select id="time_preference_2" name="time_preference_2" class="browser-default">
                    <option value="">-</option>
                    <option value="morning" {{ old('time_preference_2') == 'morning' ? 'selected' : $contact->mentor->time_preference_2 == 'morning' ? 'selected' : '' }}>Morning</option>
                    <option value="afternoon" {{ old('time_preference_2') == 'afternoon' ? 'selected' : $contact->mentor->time_preference_2 == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                    <option value="evening" {{ old('time_preference_2') == 'evening' ? 'selected' : $contact->mentor->time_preference_2 == 'evening' ? 'selected' : '' }}>Evening</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s6 m4">
                <select id="day_preference_3" name="day_preference_3" class="browser-default">
                    <option value="">-</option>
                    <option value="monday" {{ old('day_preference_3') == 'monday' ? 'selected' : $contact->mentor->day_preference_3 == 'monday' ? 'selected' : '' }}>Monday</option>
                    <option value="tuesday" {{ old('day_preference_3') == 'tuesday' ? 'selected' : $contact->mentor->day_preference_3 == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                    <option value="wednesday" {{ old('day_preference_3') == 'wednesday' ? 'selected' : $contact->mentor->day_preference_3 == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                    <option value="thursday" {{ old('day_preference_3') == 'thursday' ? 'selected' : $contact->mentor->day_preference_3 == 'thursday' ? 'selected' : '' }}>Thursday</option>
                    <option value="friday" {{ old('day_preference_3') == 'friday' ? 'selected' : $contact->mentor->day_preference_3 == 'friday' ? 'selected' : '' }}>Friday</option>
                </select>
            </div>
            <div class="col s6 m4">
                <select id="time_preference_3" name="time_preference_3" class="browser-default">
                    <option value="">-</option>
                    <option value="morning" {{ old('time_preference_3') == 'morning' ? 'selected' : $contact->mentor->time_preference_3 == 'morning' ? 'selected' : '' }}>Morning</option>
                    <option value="afternoon" {{ old('time_preference_3') == 'afternoon' ? 'selected' : $contact->mentor->time_preference_3 == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                    <option value="evening" {{ old('time_preference_3') == 'evening' ? 'selected' : $contact->mentor->time_preference_3 == 'evening' ? 'selected' : '' }}>Evening</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <p>
                    <input type="checkbox" name="active" id="active" value="1" {{ is_null(old('active')) ? ($contact->mentor->active ? "checked" : "") : (old('active') ? "checked" : "") }} />
                    <label for="active">Active mentor</label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col s12 input-field">
                <button type="submit" class="btn sbs-red">Save</button>
            </div>
        </div>
    </form>
</div>
@include('components.pdf-view-modal')
@endsection
