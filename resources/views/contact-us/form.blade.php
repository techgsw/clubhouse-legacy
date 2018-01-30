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
        <h3 class="header">Contact us</h3>
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
            <div class="input-field col s12">
                <select name="about">
                    <option value="" {{ old('state') == "" ? "selected" : "" }}></option>
                    <option value="sales-training" {{ old('state') == "sales-training" ? "selected" : $interest == "sales-training" ? "selected" : "" }}>Sales training</option>
                    <option value="consulting" {{ old('state') == "consulting" ? "selected" : $interest == "consulting" ? "selected" : "" }}>Consulting</option>
                    <option value="recruiting" {{ old('state') == "recruiting" ? "selected" : $interest == "recruiting" ? "selected" : "" }}>Recruiting</option>
                    <option value="career-services" {{ old('state') == "career-services" ? "selected" : $interest == "career-services" ? "selected" : "" }}>Job seeker career services</option>
                    <option value="coaching" {{ old('state') == "coaching" ? "selected" : $interest == "coaching" ? "selected" : "" }}>Industry professional coaching</option>
                    <option value="combine" {{ old('state') == "combine" ? "selected" : $interest == "combine" ? "selected" : "" }}>Sports Sales Combine</option>
                    <option value="keynote" {{ old('state') == "keynote" ? "selected" : $interest == "keynote" ? "selected" : "" }}>Keynote speaker opportunities</option>
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
