<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Job Board')
@section('content')
<div class="container">
    <div class="row">
        <form action="/job" method="get">
            <div class="col s6 m3">
                <div class="input-field">
                    <select name="job_type">
                        <option value="all" {{ (!request('job_type') || request('job_type') == 'all') ? "selected" : "" }}>All</option>
                        <option value="sales" {{ request('job_type') == 'sales' ? "selected" : "" }}>Sales</option>
                    </select>
                    <label>Job Type</label>
                </div>
            </div>
            <div class="col s6 m3">
                <div class="input-field">
                    <select name="league">
                        <option value="all" {{ (!request('league') || request('league') == 'all') ? "selected" : "" }}>All</option>
                        <option value="mlb" {{ request('league') == 'mlb' ? "selected" : "" }}>MLB</option>
                        <option value="mls" {{ request('league') == 'mls' ? "selected" : "" }}>MLS</option>
                        <option value="nba" {{ request('league') == 'nba' ? "selected" : "" }}>NBA</option>
                        <option value="nfl" {{ request('league') == 'nfl' ? "selected" : "" }}>NFL</option>
                        <option value="wnba" {{ request('league') == 'wnba' ? "selected" : "" }}>WNBA</option>
                    </select>
                    <label>League</label>
                </div>
            </div>
            <div class="col s6 m3">
                <div class="input-field">
                    <select name="state">
                        <option value="" {{ request('state') == "" ? "selected" : "" }}>All</option>
                        <option disabled>U.S.A.</option>
                        <option value="AL" {{ request('state') == "AL" ? "selected" : "" }}>Alabama</option>
                    	<option value="AK" {{ request('state') == "AK" ? 'selected' : '' }}>Alaska</option>
                    	<option value="AZ" {{ request('state') == "AZ" ? 'selected' : '' }}>Arizona</option>
                    	<option value="AR" {{ request('state') == "AR" ? 'selected' : '' }}>Arkansas</option>
                    	<option value="CA" {{ request('state') == "CA" ? 'selected' : '' }}>California</option>
                    	<option value="CO" {{ request('state') == "CO" ? 'selected' : '' }}>Colorado</option>
                    	<option value="CT" {{ request('state') == "CT" ? 'selected' : '' }}>Connecticut</option>
                    	<option value="DE" {{ request('state') == "DE" ? 'selected' : '' }}>Delaware</option>
                    	<option value="DC" {{ request('state') == "DC" ? 'selected' : '' }}>District Of Columbia</option>
                    	<option value="FL" {{ request('state') == "FL" ? 'selected' : '' }}>Florida</option>
                    	<option value="GA" {{ request('state') == "GA" ? 'selected' : '' }}>Georgia</option>
                    	<option value="HI" {{ request('state') == "HI" ? 'selected' : '' }}>Hawaii</option>
                    	<option value="ID" {{ request('state') == "ID" ? 'selected' : '' }}>Idaho</option>
                    	<option value="IL" {{ request('state') == "IL" ? 'selected' : '' }}>Illinois</option>
                    	<option value="IN" {{ request('state') == "IN" ? 'selected' : '' }}>Indiana</option>
                    	<option value="IA" {{ request('state') == "IA" ? 'selected' : '' }}>Iowa</option>
                    	<option value="KS" {{ request('state') == "KS" ? 'selected' : '' }}>Kansas</option>
                    	<option value="KY" {{ request('state') == "KY" ? 'selected' : '' }}>Kentucky</option>
                    	<option value="LA" {{ request('state') == "LA" ? 'selected' : '' }}>Louisiana</option>
                    	<option value="ME" {{ request('state') == "ME" ? 'selected' : '' }}>Maine</option>
                    	<option value="MD" {{ request('state') == "MD" ? 'selected' : '' }}>Maryland</option>
                    	<option value="MA" {{ request('state') == "MA" ? 'selected' : '' }}>Massachusetts</option>
                    	<option value="MI" {{ request('state') == "MI" ? 'selected' : '' }}>Michigan</option>
                    	<option value="MN" {{ request('state') == "MN" ? 'selected' : '' }}>Minnesota</option>
                    	<option value="MS" {{ request('state') == "MS" ? 'selected' : '' }}>Mississippi</option>
                    	<option value="MO" {{ request('state') == "MO" ? 'selected' : '' }}>Missouri</option>
                    	<option value="MT" {{ request('state') == "MT" ? 'selected' : '' }}>Montana</option>
                    	<option value="NE" {{ request('state') == "NE" ? 'selected' : '' }}>Nebraska</option>
                    	<option value="NV" {{ request('state') == "NV" ? 'selected' : '' }}>Nevada</option>
                    	<option value="NH" {{ request('state') == "NH" ? 'selected' : '' }}>New Hampshire</option>
                    	<option value="NJ" {{ request('state') == "NJ" ? 'selected' : '' }}>New Jersey</option>
                    	<option value="NM" {{ request('state') == "NM" ? 'selected' : '' }}>New Mexico</option>
                    	<option value="NY" {{ request('state') == "NY" ? 'selected' : '' }}>New York</option>
                    	<option value="NC" {{ request('state') == "NC" ? 'selected' : '' }}>North Carolina</option>
                    	<option value="ND" {{ request('state') == "ND" ? 'selected' : '' }}>North Dakota</option>
                    	<option value="OH" {{ request('state') == "OH" ? 'selected' : '' }}>Ohio</option>
                    	<option value="OK" {{ request('state') == "OK" ? 'selected' : '' }}>Oklahoma</option>
                    	<option value="OR" {{ request('state') == "OR" ? 'selected' : '' }}>Oregon</option>
                    	<option value="PA" {{ request('state') == "PA" ? 'selected' : '' }}>Pennsylvania</option>
                    	<option value="RI" {{ request('state') == "RI" ? 'selected' : '' }}>Rhode Island</option>
                    	<option value="SC" {{ request('state') == "SC" ? 'selected' : '' }}>South Carolina</option>
                    	<option value="SD" {{ request('state') == "SD" ? 'selected' : '' }}>South Dakota</option>
                    	<option value="TN" {{ request('state') == "TN" ? 'selected' : '' }}>Tennessee</option>
                    	<option value="TX" {{ request('state') == "TX" ? 'selected' : '' }}>Texas</option>
                    	<option value="UT" {{ request('state') == "UT" ? 'selected' : '' }}>Utah</option>
                    	<option value="VT" {{ request('state') == "VT" ? 'selected' : '' }}>Vermont</option>
                    	<option value="VA" {{ request('state') == "VA" ? 'selected' : '' }}>Virginia</option>
                    	<option value="WA" {{ request('state') == "WA" ? 'selected' : '' }}>Washington</option>
                    	<option value="WV" {{ request('state') == "WV" ? 'selected' : '' }}>West Virginia</option>
                    	<option value="WI" {{ request('state') == "WI" ? 'selected' : '' }}>Wisconsin</option>
                    	<option value="WY" {{ request('state') == "WY" ? 'selected' : '' }}>Wyoming</option>
                        <option disabled>Canada</option>
                        <option value="AB" {{ request('state') == "AB" ? 'selected' : '' }}>Alberta</option>
                    	<option value="BC" {{ request('state') == "BC" ? 'selected' : '' }}>British Columbia</option>
                    	<option value="MB" {{ request('state') == "MB" ? 'selected' : '' }}>Manitoba</option>
                    	<option value="NB" {{ request('state') == "NB" ? 'selected' : '' }}>New Brunswick</option>
                    	<option value="NL" {{ request('state') == "NL" ? 'selected' : '' }}>Newfoundland and Labrador</option>
                    	<option value="NS" {{ request('state') == "NS" ? 'selected' : '' }}>Nova Scotia</option>
                    	<option value="ON" {{ request('state') == "ON" ? 'selected' : '' }}>Ontario</option>
                    	<option value="PE" {{ request('state') == "PE" ? 'selected' : '' }}>Prince Edward Island</option>
                    	<option value="QC" {{ request('state') == "QC" ? 'selected' : '' }}>Quebec</option>
                    	<option value="SK" {{ request('state') == "SK" ? 'selected' : '' }}>Saskatchewan</option>
                    	<option value="NT" {{ request('state') == "NT" ? 'selected' : '' }}>Northwest Territories</option>
                    	<option value="NU" {{ request('state') == "NU" ? 'selected' : '' }}>Nunavut</option>
                    	<option value="YT" {{ request('state') == "YT" ? 'selected' : '' }}>Yukon</option>
                    </select>
                    <label for="state">State</label>
                </div>
            </div>
            <div class="col s6 m3">
                <div class="input-field">
                    <input type="text" name="organization" id="organization" value="{{ request('organization') }}">
                    <label for="organization">Organization</label>
                </div>
            </div>
            <div class="col s12 input-field center-align">
                <button type="submit" name="search" class="btn btn-large sbs-red">Search</button>
            </div>
        </form>
    </div>
    @if (count($jobs) > 0)
        <div class="row">
            <div class="col s12">
                @foreach ($jobs as $job)
                    <a href="/job/{{ $job->id }}">
                        <div class="row job-index">
                            <div class="col s3 m2">
                                <img src={{ Storage::disk('local')->url($job->image_url) }} class="thumb">
                            </div>
                            <div class="col s9 m7">
                                <h5>{{ $job->title }}</h5>
                                <p>{{ $job->organization }} <i class="fa fa-map-pin spaced" aria-hidden="true"></i> {{ $job->city }}, {{ $job->state }}</p>
                                <p>listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
                            </div>
                            <div class="col s12 m3 center-align">
                                @can ('create-inquiry')
                                    <a href="/job/{{ $job->id }}" class="btn white black-text">Apply</a>
                                @else
                                    <a href="/register" class="btn white black-text">Join to apply</a>
                                @endcan
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col s12 center-align">
                {{ $jobs->links('components.pagination') }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12">
                <p>No jobs right now. Check back soon!</p>
            </div>
        </div>
    @endif
</div>
@endsection
