<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit Job')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>Posted on {{ $job->created_at->format('F j, Y g:ia') }}</p>
        </div>
    </div>
    <form id="edit-job" method="POST" action="/job/{{ $job->id }}" enctype="multipart/form-data">
        <div class="row">
            {{ csrf_field() }}
            <div class="input-field col s12 m6">
                <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') ?: $job->title }}" required autofocus>
                <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
            </div>
            <div class="input-field col s12 m3">
                <input type="checkbox" name="featured" id="featured" value="1" {{ is_null(old('featured')) ? ($job->featured ? "checked" : "") : (old('featured') ? "checked" : "") }} />
                <label for="featured">Featured</label>
            </div>
            <div class="input-field col s12 m3">
                <input type="number" step="1" min="1" name="rank" id="rank" value="{{ old('rank') ?: $job->rank ?: '' }}" disabled />
                <label for="rank">Rank</label>
            </div>
            <div class="input-field col s12">
                <textarea id="description" class="materialize-textarea validate {{ $errors->has('description') ? 'invalid' : '' }}" name="description" required>{{ old('description') ?: $job->description }}</textarea>
                <label for="description" data-error="{{ $errors->first('description') }}">Description</label>
            </div>
            <div class="input-field col s12">
                <input id="organization" type="text" class="validate {{ $errors->has('organization') ? 'invalid' : '' }}" name="organization" value="{{ old('organization') ?: $job->organization }}" required autofocus>
                <label for="organization" data-error="{{ $errors->first('organization') }}">Organization</label>
            </div>
            <div class="input-field col s12">
                <select name="league">
                    <option value="" {{ old('league') == "" ? "selected" : is_null($job->league) ? "selected" : "" }}>None</option>
                    <option value="mlb" {{ old('league') == "mlb" ? "selected" : $job->league == "mlb" ? "selected" : "" }}>MLB</option>
                    <option value="mls" {{ old('league') == "mls" ? "selected" : $job->league == "mls" ? "selected" : "" }}>MLS</option>
                    <option value="nba" {{ old('league') == "nba" ? "selected" : $job->league == "nba" ? "selected" : "" }}>NBA</option>
                    <option value="ncaa" {{ old('league') == "ncaa" ? "selected" : $job->league == "ncaa" ? "selected" : "" }}>NCAA</option>
                    <option value="nfl" {{ old('league') == "nfl" ? "selected" : $job->league == "nfl" ? "selected" : "" }}>NFL</option>
                    <option value="nhl" {{ old('league') == "nhl" ? "selected" : $job->league == "nhl" ? "selected" : "" }}>NHL</option>
                    <option value="wnba" {{ old('league') == "wnba" ? "selected" : $job->league == "wnba" ? "selected" : "" }}>WNBA</option>
                    <option value="other" {{ old('league') == "other" ? "selected" : $job->league == "other" ? "selected" : "" }}>Other</option>
                </select>
                <label>League</label>
            </div>
            <div class="input-field col s12">
                <select name="job_type">
                    <option value="" {{ old("job_type") == "" ? "selected" : is_null($job->job_type) ? "selected" : "" }}>None</option>
                    <option value="ticket-sales" {{ old("job_type") == "ticket-sales" ? "selected" : $job->job_type == "ticket-sales" ? "selected" : "" }}>Ticket Sales</option>
                    <option value="sponsorship-sales" {{ old("job_type") == "sponsorship-sales" ? "selected" : $job->job_type == "sponsorship-sales" ? "selected" : "" }}>Sponsorship Sales</option>
                    <option value="marketing" {{ old("job_type") == "marketing" ? "selected" : $job->job_type == "marketing" ? "selected" : "" }}>Marketing</option>
                    <option value="internships" {{ old("job_type") == "internships" ? "selected" : $job->job_type == "internships" ? "selected" : "" }}>Internships</option>
                    <option value="business-operations" {{ old("job_type") == "business-operations" ? "selected" : $job->job_type == "business-operations" ? "selected" : "" }}>Business operations</option>
                    <option value="data-analytics" {{ old("job_type") == "data-analytics" ? "selected" : $job->job_type == "data-analytics" ? "selected" : "" }}>Data/Analytics</option>
                    <option value="player-operations" {{ old("job_type") == "player-operations" ? "selected" : $job->job_type == "player-operations" ? "selected" : "" }}>Player operations</option>
                    <option value="communications" {{ old("job_type") == "communications" ? "selected" : $job->job_type == "communications" ? "selected" : "" }}>Communications</option>
                    <option value="it-technology" {{ old("job_type") == "it-technology" ? "selected" : $job->job_type == "it-technology" ? "selected" : "" }}>IT and Technology</option>
                    <option value="administrative" {{ old("job_type") == "administrative" ? "selected" : $job->job_type == "administrative" ? "selected" : "" }}>Administrative</option>
                </select>
                <label>Type</label>
            </div>
            <div class="row">
                <div class="col s12 m4">
                    @if (!is_null($job->image))
                        <img src={{ $job->image->getURL('medium') }}>
                    @endif
                </div>
                <div class="col s12 m8">
                    <div class="file-field input-field">
                        <div class="btn white black-text">
                            <span>Upload Image</span>
                            <input type="file" name="image_url" value="{{ old('image_url') }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="image_url_text" value="{{ old('image_url_text') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-field col s12">
                <input id="city" type="text" class="validate {{ $errors->has('city') ? 'invalid' : '' }}" name="city" value="{{ old('city') ?: $job->city }}" required autofocus>
                <label for="city" data-error="{{ $errors->first('city') }}">City</label>
            </div>
            <div class="input-field col s6">
                <select name="state">
                    <option value="" {{ old("state") == "" ? "selected" : is_null($job->state) ? "selected" : "" }} disabled>U.S.A.</option>
                    <option value="AL" {{ old('state') == "AL" ? "selected" : $job->state == "AL" ? 'selected' : '' }}>Alabama</option>
                	<option value="AK" {{ old('state') == "AK" ? 'selected' : $job->state == "AK" ? 'selected' : '' }}>Alaska</option>
                	<option value="AZ" {{ old('state') == "AZ" ? 'selected' : $job->state == "AZ" ? 'selected' : '' }}>Arizona</option>
                	<option value="AR" {{ old('state') == "AR" ? 'selected' : $job->state == "AR" ? 'selected' : '' }}>Arkansas</option>
                	<option value="CA" {{ old('state') == "CA" ? 'selected' : $job->state == "CA" ? 'selected' : '' }}>California</option>
                	<option value="CO" {{ old('state') == "CO" ? 'selected' : $job->state == "CO" ? 'selected' : '' }}>Colorado</option>
                	<option value="CT" {{ old('state') == "CT" ? 'selected' : $job->state == "CT" ? 'selected' : '' }}>Connecticut</option>
                	<option value="DE" {{ old('state') == "DE" ? 'selected' : $job->state == "DE" ? 'selected' : '' }}>Delaware</option>
                	<option value="DC" {{ old('state') == "DC" ? 'selected' : $job->state == "DC" ? 'selected' : '' }}>District Of Columbia</option>
                	<option value="FL" {{ old('state') == "FL" ? 'selected' : $job->state == "FL" ? 'selected' : '' }}>Florida</option>
                	<option value="GA" {{ old('state') == "GA" ? 'selected' : $job->state == "GA" ? 'selected' : '' }}>Georgia</option>
                	<option value="HI" {{ old('state') == "HI" ? 'selected' : $job->state == "HI" ? 'selected' : '' }}>Hawaii</option>
                	<option value="ID" {{ old('state') == "ID" ? 'selected' : $job->state == "ID" ? 'selected' : '' }}>Idaho</option>
                	<option value="IL" {{ old('state') == "IL" ? 'selected' : $job->state == "IL" ? 'selected' : '' }}>Illinois</option>
                	<option value="IN" {{ old('state') == "IN" ? 'selected' : $job->state == "IN" ? 'selected' : '' }}>Indiana</option>
                	<option value="IA" {{ old('state') == "IA" ? 'selected' : $job->state == "IA" ? 'selected' : '' }}>Iowa</option>
                	<option value="KS" {{ old('state') == "KS" ? 'selected' : $job->state == "KS" ? 'selected' : '' }}>Kansas</option>
                	<option value="KY" {{ old('state') == "KY" ? 'selected' : $job->state == "KY" ? 'selected' : '' }}>Kentucky</option>
                	<option value="LA" {{ old('state') == "LA" ? 'selected' : $job->state == "LA" ? 'selected' : '' }}>Louisiana</option>
                	<option value="ME" {{ old('state') == "ME" ? 'selected' : $job->state == "ME" ? 'selected' : '' }}>Maine</option>
                	<option value="MD" {{ old('state') == "MD" ? 'selected' : $job->state == "MD" ? 'selected' : '' }}>Maryland</option>
                	<option value="MA" {{ old('state') == "MA" ? 'selected' : $job->state == "MA" ? 'selected' : '' }}>Massachusetts</option>
                	<option value="MI" {{ old('state') == "MI" ? 'selected' : $job->state == "MI" ? 'selected' : '' }}>Michigan</option>
                	<option value="MN" {{ old('state') == "MN" ? 'selected' : $job->state == "MN" ? 'selected' : '' }}>Minnesota</option>
                	<option value="MS" {{ old('state') == "MS" ? 'selected' : $job->state == "MS" ? 'selected' : '' }}>Mississippi</option>
                	<option value="MO" {{ old('state') == "MO" ? 'selected' : $job->state == "MO" ? 'selected' : '' }}>Missouri</option>
                	<option value="MT" {{ old('state') == "MT" ? 'selected' : $job->state == "MT" ? 'selected' : '' }}>Montana</option>
                	<option value="NE" {{ old('state') == "NE" ? 'selected' : $job->state == "NE" ? 'selected' : '' }}>Nebraska</option>
                	<option value="NV" {{ old('state') == "NV" ? 'selected' : $job->state == "NV" ? 'selected' : '' }}>Nevada</option>
                	<option value="NH" {{ old('state') == "NH" ? 'selected' : $job->state == "NH" ? 'selected' : '' }}>New Hampshire</option>
                	<option value="NJ" {{ old('state') == "NJ" ? 'selected' : $job->state == "NJ" ? 'selected' : '' }}>New Jersey</option>
                	<option value="NM" {{ old('state') == "NM" ? 'selected' : $job->state == "NM" ? 'selected' : '' }}>New Mexico</option>
                	<option value="NY" {{ old('state') == "NY" ? 'selected' : $job->state == "NY" ? 'selected' : '' }}>New York</option>
                	<option value="NC" {{ old('state') == "NC" ? 'selected' : $job->state == "NC" ? 'selected' : '' }}>North Carolina</option>
                	<option value="ND" {{ old('state') == "ND" ? 'selected' : $job->state == "ND" ? 'selected' : '' }}>North Dakota</option>
                	<option value="OH" {{ old('state') == "OH" ? 'selected' : $job->state == "OH" ? 'selected' : '' }}>Ohio</option>
                	<option value="OK" {{ old('state') == "OK" ? 'selected' : $job->state == "OK" ? 'selected' : '' }}>Oklahoma</option>
                	<option value="OR" {{ old('state') == "OR" ? 'selected' : $job->state == "OR" ? 'selected' : '' }}>Oregon</option>
                	<option value="PA" {{ old('state') == "PA" ? 'selected' : $job->state == "PA" ? 'selected' : '' }}>Pennsylvania</option>
                	<option value="RI" {{ old('state') == "RI" ? 'selected' : $job->state == "RI" ? 'selected' : '' }}>Rhode Island</option>
                	<option value="SC" {{ old('state') == "SC" ? 'selected' : $job->state == "SC" ? 'selected' : '' }}>South Carolina</option>
                	<option value="SD" {{ old('state') == "SD" ? 'selected' : $job->state == "SD" ? 'selected' : '' }}>South Dakota</option>
                	<option value="TN" {{ old('state') == "TN" ? 'selected' : $job->state == "TN" ? 'selected' : '' }}>Tennessee</option>
                	<option value="TX" {{ old('state') == "TX" ? 'selected' : $job->state == "TX" ? 'selected' : '' }}>Texas</option>
                	<option value="UT" {{ old('state') == "UT" ? 'selected' : $job->state == "UT" ? 'selected' : '' }}>Utah</option>
                	<option value="VT" {{ old('state') == "VT" ? 'selected' : $job->state == "VT" ? 'selected' : '' }}>Vermont</option>
                	<option value="VA" {{ old('state') == "VA" ? 'selected' : $job->state == "VA" ? 'selected' : '' }}>Virginia</option>
                	<option value="WA" {{ old('state') == "WA" ? 'selected' : $job->state == "WA" ? 'selected' : '' }}>Washington</option>
                	<option value="WV" {{ old('state') == "WV" ? 'selected' : $job->state == "WV" ? 'selected' : '' }}>West Virginia</option>
                	<option value="WI" {{ old('state') == "WI" ? 'selected' : $job->state == "WI" ? 'selected' : '' }}>Wisconsin</option>
                	<option value="WY" {{ old('state') == "WY" ? 'selected' : $job->state == "WY" ? 'selected' : '' }}>Wyoming</option>
                    <option disabled>Canada</option>
                    <option value="AB" {{ old('state') == "AB" ? 'selected' : $job->state == "AB" ? 'selected' : '' }}>Alberta</option>
                	<option value="BC" {{ old('state') == "BC" ? 'selected' : $job->state == "BC" ? 'selected' : '' }}>British Columbia</option>
                	<option value="MB" {{ old('state') == "MB" ? 'selected' : $job->state == "MB" ? 'selected' : '' }}>Manitoba</option>
                	<option value="NB" {{ old('state') == "NB" ? 'selected' : $job->state == "NB" ? 'selected' : '' }}>New Brunswick</option>
                	<option value="NL" {{ old('state') == "NL" ? 'selected' : $job->state == "NL" ? 'selected' : '' }}>Newfoundland and Labrador</option>
                	<option value="NS" {{ old('state') == "NS" ? 'selected' : $job->state == "NS" ? 'selected' : '' }}>Nova Scotia</option>
                	<option value="ON" {{ old('state') == "ON" ? 'selected' : $job->state == "ON" ? 'selected' : '' }}>Ontario</option>
                	<option value="PE" {{ old('state') == "PE" ? 'selected' : $job->state == "PE" ? 'selected' : '' }}>Prince Edward Island</option>
                	<option value="QC" {{ old('state') == "QC" ? 'selected' : $job->state == "QC" ? 'selected' : '' }}>Quebec</option>
                	<option value="SK" {{ old('state') == "SK" ? 'selected' : $job->state == "SK" ? 'selected' : '' }}>Saskatchewan</option>
                	<option value="NT" {{ old('state') == "NT" ? 'selected' : $job->state == "NT" ? 'selected' : '' }}>Northwest Territories</option>
                	<option value="NU" {{ old('state') == "NU" ? 'selected' : $job->state == "NU" ? 'selected' : '' }}>Nunavut</option>
                	<option value="YT" {{ old('state') == "YT" ? 'selected' : $job->state == "YT" ? 'selected' : '' }}>Yukon</option>
                    <option disabled>U.K.</option>
                    <option value="England" {{ old('state') == "England" ? 'selected' : $job->state == "England" ? 'selected' : '' }}>England</option>
                    <option value="Northern Ireland" {{ old('state') == "Northern Ireland" ? 'selected' : $job->state == "Northern Ireland" ? 'selected' : '' }}>Northern Ireland</option>
                    <option value="Scotland" {{ old('state') == "Scotland" ? 'selected' : $job->state == "Scotland" ? 'selected' : '' }}>Scotland</option>
                    <option value="Wales" {{ old('state') == "Wales" ? 'selected' : $job->state == "Wales" ? 'selected' : '' }}>Wales</option>
                </select>
                <label>State</label>
            </div>
            <div class="input-field col s6">
                <select name="country">
                    <option value="US" {{ old('country') == "US" ? 'selected' : $job->country == "US" ? 'selected' : '' }}>U.S.A.</option>
                    <option value="CA" {{ old('country') == "CA" ? 'selected' : $job->country == "CA" ? 'selected' : '' }}>Canada</option>
                    <option value="UK" {{ old('country') == "UK" ? 'selected' : $job->country == "UK" ? 'selected' : '' }}>U.K.</option>
                </select>
                <label>Country</label>
            </div>
            <div class="file-field input-field col s12">
                <div class="btn white black-text">
                    <span>Upload Document</span>
                    <input type="file" name="document" value="{{ old('document') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" name="document_text" value="{{ old('document_text') }}">
                </div>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="btn sbs-red">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
