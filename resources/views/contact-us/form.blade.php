@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
    <form action="/contact" method="post">
        {{ csrf_field() }}
        <h3 class="header">Contact SBS Consulting</h3>
        <div class="row">
            <div class="input-field col s12 m6 {{ $errors->has('first_name') ? 'invalid' : '' }}">
                <input id="first-name" type="text" name="first_name" value="{{ old('first_name') }}" required>
                <label for="first-name">First name</label>
            </div>
            <div class="input-field col s12 m6 {{ $errors->has('last_name') ? 'invalid' : '' }}">
                <input id="last-name" type="text" name="last_name" value="{{ old('last_name') }}" required>
                <label for="last-name">Last name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 {{ $errors->has('email') ? 'invalid' : '' }}">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                <label for="email">Email Address</label>
            </div>
            <div class="input-field col s12 m6 {{ $errors->has('phone') ? 'invalid' : '' }}">
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
                <label for="phone">Phone number</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="organization" type="text" name="organization" value="{{ old('organization') }}">
                <label for="organization">Organization</label>
            </div>
            <div class="input-field col s12 m6">
                <select name="about">
                    <option value="" {{ old('state') == "" ? "selected" : "" }}></option>
                    <option value="sales-training-consulting" {{ old('state') == "sales-training-consulting" ? "selected" : $interest == "sales-training-consulting" ? "selected" : "" }}>Sales Training & Consulting</option>
                    <option value="recruiting" {{ old('state') == "recruiting" ? "selected" : $interest == "recruiting" ? "selected" : "" }}>Recruiting</option>
                    <option value="clubhouse" {{ old('state') == "clubhouse" ? "selected" : $interest == "clubhouse" ? "selected" : "" }}>theClubhouse</option>
                    <option value="other" {{ old('state') == "other" ? "selected" : $interest == "other" ? "selected" : "" }}>Other</option>
                </select>
                <label>I'm interested in:</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea id="body" class="materialize-textarea {{ $errors->has('body') ? 'invalid' : '' }}" name="body" required></textarea>
                <label for="body">Body</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 30px">
            <div class="input-field col s12">
                <button type="submit" class="btn sbs-red">Send</button>
            </div>
        </div>
    </form>
</div>
@endsection
