<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.default')
@section('title', 'New Job')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form method="post" action="/job" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-field">
                    <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
                    <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                </div>
                <div class="input-field">
                    <textarea id="description" class="materialize-textarea validate {{ $errors->has('description') ? 'invalid' : '' }}" name="description" required>{{ old('description') }}</textarea>
                    <label for="description" data-error="{{ $errors->first('description') }}">Description</label>
                </div>
                <div class="input-field">
                    <input id="organization" type="text" class="validate {{ $errors->has('organization') ? 'invalid' : '' }}" name="organization" value="{{ old('organization') }}" required autofocus>
                    <label for="organization" data-error="{{ $errors->first('organization') }}">Organization</label>
                </div>
                <div class="input-field">
                    <select name="league">
                        <option value="" {{ old('state') == "" ? "selected" : "" }}>None</option>
                        <option value="mlb" {{ old('state') == "mlb" ? "selected" : "" }}>MLB</option>
                        <option value="mls" {{ old('state') == "mls" ? "selected" : "" }}>MLS</option>
                        <option value="nba" {{ old('state') == "nba" ? "selected" : "" }}>NBA</option>
                        <option value="nfl" {{ old('state') == "nfl" ? "selected" : "" }}>NFL</option>
                        <option value="wnba" {{ old('state') == "wnba" ? "selected" : "" }}>WNBA</option>
                    </select>
                    <label>League</label>
                </div>
                <div class="input-field">
                    <select name="job_type">
                        <option value="" {{ old('state') == "" ? "selected" : "" }}>None</option>
                        <option value="sales" {{ old('state') == "sales" ? "selected" : "" }}>Sales</option>
                    </select>
                    <label>Type</label>
                </div>
                <div class="file-field input-field">
                    <div class="btn white black-text">
                        <span>Upload Image</span>
                        <input type="file" name="image_url" value="{{ old('image_url') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="image_url_text" value="{{ old('image_url_text') }}">
                    </div>
                </div>
                <div class="input-field">
                    <input id="city" type="text" class="validate {{ $errors->has('city') ? 'invalid' : '' }}" name="city" value="{{ old('city') }}" required autofocus>
                    <label for="city" data-error="{{ $errors->first('city') }}">City</label>
                </div>
                <div class="input-field">
                    <select name="state">
                        <option value="" {{ old('state') == "" ? "selected" : "" }} disabled>U.S.A.</option>
                        <option value="AL" {{ old('state') == "AL" ? "selected" : "" }}>Alabama</option>
                    	<option value="AK" {{ old('state') == "AK" ? 'selected' : '' }}>Alaska</option>
                    	<option value="AZ" {{ old('state') == "AZ" ? 'selected' : '' }}>Arizona</option>
                    	<option value="AR" {{ old('state') == "AR" ? 'selected' : '' }}>Arkansas</option>
                    	<option value="CA" {{ old('state') == "CA" ? 'selected' : '' }}>California</option>
                    	<option value="CO" {{ old('state') == "CO" ? 'selected' : '' }}>Colorado</option>
                    	<option value="CT" {{ old('state') == "CT" ? 'selected' : '' }}>Connecticut</option>
                    	<option value="DE" {{ old('state') == "DE" ? 'selected' : '' }}>Delaware</option>
                    	<option value="DC" {{ old('state') == "DC" ? 'selected' : '' }}>District Of Columbia</option>
                    	<option value="FL" {{ old('state') == "FL" ? 'selected' : '' }}>Florida</option>
                    	<option value="GA" {{ old('state') == "GA" ? 'selected' : '' }}>Georgia</option>
                    	<option value="HI" {{ old('state') == "HI" ? 'selected' : '' }}>Hawaii</option>
                    	<option value="ID" {{ old('state') == "ID" ? 'selected' : '' }}>Idaho</option>
                    	<option value="IL" {{ old('state') == "IL" ? 'selected' : '' }}>Illinois</option>
                    	<option value="IN" {{ old('state') == "IN" ? 'selected' : '' }}>Indiana</option>
                    	<option value="IA" {{ old('state') == "IA" ? 'selected' : '' }}>Iowa</option>
                    	<option value="KS" {{ old('state') == "KS" ? 'selected' : '' }}>Kansas</option>
                    	<option value="KY" {{ old('state') == "KY" ? 'selected' : '' }}>Kentucky</option>
                    	<option value="LA" {{ old('state') == "LA" ? 'selected' : '' }}>Louisiana</option>
                    	<option value="ME" {{ old('state') == "ME" ? 'selected' : '' }}>Maine</option>
                    	<option value="MD" {{ old('state') == "MD" ? 'selected' : '' }}>Maryland</option>
                    	<option value="MA" {{ old('state') == "MA" ? 'selected' : '' }}>Massachusetts</option>
                    	<option value="MI" {{ old('state') == "MI" ? 'selected' : '' }}>Michigan</option>
                    	<option value="MN" {{ old('state') == "MN" ? 'selected' : '' }}>Minnesota</option>
                    	<option value="MS" {{ old('state') == "MS" ? 'selected' : '' }}>Mississippi</option>
                    	<option value="MO" {{ old('state') == "MO" ? 'selected' : '' }}>Missouri</option>
                    	<option value="MT" {{ old('state') == "MT" ? 'selected' : '' }}>Montana</option>
                    	<option value="NE" {{ old('state') == "NE" ? 'selected' : '' }}>Nebraska</option>
                    	<option value="NV" {{ old('state') == "NV" ? 'selected' : '' }}>Nevada</option>
                    	<option value="NH" {{ old('state') == "NH" ? 'selected' : '' }}>New Hampshire</option>
                    	<option value="NJ" {{ old('state') == "NJ" ? 'selected' : '' }}>New Jersey</option>
                    	<option value="NM" {{ old('state') == "NM" ? 'selected' : '' }}>New Mexico</option>
                    	<option value="NY" {{ old('state') == "NY" ? 'selected' : '' }}>New York</option>
                    	<option value="NC" {{ old('state') == "NC" ? 'selected' : '' }}>North Carolina</option>
                    	<option value="ND" {{ old('state') == "ND" ? 'selected' : '' }}>North Dakota</option>
                    	<option value="OH" {{ old('state') == "OH" ? 'selected' : '' }}>Ohio</option>
                    	<option value="OK" {{ old('state') == "OK" ? 'selected' : '' }}>Oklahoma</option>
                    	<option value="OR" {{ old('state') == "OR" ? 'selected' : '' }}>Oregon</option>
                    	<option value="PA" {{ old('state') == "PA" ? 'selected' : '' }}>Pennsylvania</option>
                    	<option value="RI" {{ old('state') == "RI" ? 'selected' : '' }}>Rhode Island</option>
                    	<option value="SC" {{ old('state') == "SC" ? 'selected' : '' }}>South Carolina</option>
                    	<option value="SD" {{ old('state') == "SD" ? 'selected' : '' }}>South Dakota</option>
                    	<option value="TN" {{ old('state') == "TN" ? 'selected' : '' }}>Tennessee</option>
                    	<option value="TX" {{ old('state') == "TX" ? 'selected' : '' }}>Texas</option>
                    	<option value="UT" {{ old('state') == "UT" ? 'selected' : '' }}>Utah</option>
                    	<option value="VT" {{ old('state') == "VT" ? 'selected' : '' }}>Vermont</option>
                    	<option value="VA" {{ old('state') == "VA" ? 'selected' : '' }}>Virginia</option>
                    	<option value="WA" {{ old('state') == "WA" ? 'selected' : '' }}>Washington</option>
                    	<option value="WV" {{ old('state') == "WV" ? 'selected' : '' }}>West Virginia</option>
                    	<option value="WI" {{ old('state') == "WI" ? 'selected' : '' }}>Wisconsin</option>
                    	<option value="WY" {{ old('state') == "WY" ? 'selected' : '' }}>Wyoming</option>
                        <option disabled>Canada</option>
                        <option value="AB" {{ old('state') == "AB" ? 'selected' : '' }}>Alberta</option>
                    	<option value="BC" {{ old('state') == "BC" ? 'selected' : '' }}>British Columbia</option>
                    	<option value="MB" {{ old('state') == "MB" ? 'selected' : '' }}>Manitoba</option>
                    	<option value="NB" {{ old('state') == "NB" ? 'selected' : '' }}>New Brunswick</option>
                    	<option value="NL" {{ old('state') == "NL" ? 'selected' : '' }}>Newfoundland and Labrador</option>
                    	<option value="NS" {{ old('state') == "NS" ? 'selected' : '' }}>Nova Scotia</option>
                    	<option value="ON" {{ old('state') == "ON" ? 'selected' : '' }}>Ontario</option>
                    	<option value="PE" {{ old('state') == "PE" ? 'selected' : '' }}>Prince Edward Island</option>
                    	<option value="QC" {{ old('state') == "QC" ? 'selected' : '' }}>Quebec</option>
                    	<option value="SK" {{ old('state') == "SK" ? 'selected' : '' }}>Saskatchewan</option>
                    	<option value="NT" {{ old('state') == "NT" ? 'selected' : '' }}>Northwest Territories</option>
                    	<option value="NU" {{ old('state') == "NU" ? 'selected' : '' }}>Nunavut</option>
                    	<option value="YT" {{ old('state') == "YT" ? 'selected' : '' }}>Yukon</option>
                    </select>
                    <label>State</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="btn sbs-red">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
