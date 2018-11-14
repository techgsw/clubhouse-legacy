<!-- /resources/views/contact/create.blade.php -->
@extends('layouts.default')
@section('title', 'New Contact')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <form method="post" action="/contact" enctype="multipart/form-data">
        <div class="row">
            {{ csrf_field() }}
            <div class="col s12">
                <h2 style="text-transform: uppercase; letter-spacing: 0.4px; font-weight: 700; font-size: 16px; margin-top: 0;">Personal</h2>
            </div>
            <div class="col s12 m6">
                <label for="first_name" data-error="{{ $errors->first('first_name') }}">First name</label>
                <input id="first_name" type="text" class="validate {{ $errors->has('first_name') ? 'invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required>
            </div>
            <div class="col s12 m6">
                <label for="last_name" data-error="{{ $errors->first('last_name') }}">Last name</label>
                <input id="last_name" type="text" class="validate {{ $errors->has('last_name') ? 'invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
            </div>
            <div class="col s12 m6">
                <label for="email" data-error="{{ $errors->first('email') }}">Email</label>
                <input id="email" type="text" class="validate {{ $errors->has('email') ? 'invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="col s12 m6">
                <label for="phone" data-error="{{ $errors->first('phone') }}">Phone</label>
                <input id="phone" type="text" class="validate {{ $errors->has('phone') ? 'invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
            </div>
            <div class="col s12">
                <h2 style="text-transform: uppercase; letter-spacing: 0.4px; font-weight: 700; font-size: 16px;">Professional</h2>
            </div>
            <div class="col s12">
                <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="col s12">
                <label for="organization" data-error="{{ $errors->first('organization') }}">Organization</label>
                <input id="organization" type="text" class="organization-autocomplete validate {{ $errors->has('organization') ? 'invalid' : '' }}" name="organization" value="{{ old('organization') }}" required>
            </div>
            <div class="col s12">
                <div class="file-field input-field">
                    <div class="flat-button" style="float: left;">
                        <span>Upload<span class="hide-on-small-only"> Resume</span></span>
                        <input type="file" name="resume" value="{{ old('resume') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="resume_text" style="height: 1.8em;" value="{{ old('resume_text') }}">
                    </div>
                </div>
            </div>
            <div class="col s12">
                <label>Job-seeking status</label>
                <select class="browser-default" style="margin-bottom: 20px" name="job_seeking_status">
                    <option value="" {{ old("job_seeking_status") == "" ? "selected" : "" }} disabled>Please select</option>
                    <option value="unemployed" {{ old("job_seeking_status") == "unemployed" ? "selected" : "" }}>Unemployed, actively seeking a new job</option>
                    <option value="employed_active" {{ old("job_seeking_status") == "employed_active" ? "selected" : "" }}>Employed, actively seeking a new job</option>
                    <option value="employed_passive" {{ old("job_seeking_status") == "employed_passive" ? "selected" : "" }}>Employed, passively exploring new opportunities</option>
                    <option value="employed_future" {{ old("job_seeking_status") == "employed_future" ? "selected" : "" }}>Employed, only open to future opportunities</option>
                    <option value="employed_not" {{ old("job_seeking_status") == "employed_not" ? "selected" : "" }}>Employed, currently have my dream job</option>
                </select>
            </div>
            <div class="col s12">
                <label>Job-seeking type</label>
                <select class="browser-default" style="margin-bottom: 20px" name="job_seeking_type">
                    <option value="" {{ old("job_seeking_type") == "" ? "selected" : "" }} disabled>Please select</option>
                    <option value="internship" {{ old("job_seeking_type") == "internship" ? "selected" : "" }}>Internship</option>
                    <option value="entry_level" {{ old("job_seeking_type") == "entry_level" ? "selected" : "" }}>Entry-level</option>
                    <option value="mid_level" {{ old("job_seeking_type") == "mid_level" ? "selected" : "" }}>Mid-level</option>
                    <option value="entry_level_management" {{ old("job_seeking_type") == "entry_level-managment" ? "selected" : "" }}>Entry-level management</option>
                    <option value="mid_level_management" {{ old("job_seeking_type") == "mid_level-managment" ? "selected" : "" }}>Mid-level management</option>
                    <option value="executive" {{ old("job_seeking_type") == "executive" ? "selected" : "" }}>Executive team</option>
                </select>
            </div>
            <div class="col s12">
                <label for="line1">Notes</label>
                <textarea id="note" name="note"></textarea>
            </div>
            <div class="col s12">
                <h2 style="text-transform: uppercase; letter-spacing: 0.4px; font-weight: 700; font-size: 16px;">Address</h2>
            </div>
            <div class="col s12">
                <label for="line1">Street address</label>
                <input id="line1" name="line1" type="text" value="{{ old('line1') ?: "" }}">
            </div>
            <div class="col s12">
                <label for="line2">Line 2</label>
                <input id="line2" name="line2" type="text" value="{{ old('line2') ?: "" }}">
            </div>
            <div class="col s12 m4">
                <label for="city">City</label>
                <input id="city" name="city" type="text" value="{{ old('city') ?: "" }}">
            </div>
            <div class="col s12 m2">
                <label for="state">State/Province</label>
                <input id="state" name="state" type="text" value="{{ old('state') ?: "" }}">
            </div>
            <div class="col s12 m3">
                <label for="postal_code">Postal code</label>
                <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') ?: "" }}">
            </div>
            <div class="col s12 m3">
                <label for="country">Country</label>
                <input id="country" name="country" type="text" value="{{ old('country') ?: "" }}">
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn sbs-red">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
