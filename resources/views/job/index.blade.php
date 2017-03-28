<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Job Board')
@section('content')
<div class="row">
    <form action="/job" method="get">
        <div class="col s6 m3 input-field">
            <div class="input-field">
                <select name="job_type">
                    <option value="all" {{ (!request('job_type') || request('job_type') == 'all') ? "selected" : "" }}>All</option>
                    <option value="sales" {{ request('job_type') == 'sales' ? "selected" : "" }}>Sales</option>
                </select>
                <label>Job Type</label>
            </div>
        </div>
        <div class="col s6 m3 input-field">
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
        <div class="col s6 m3 input-field">
            <div class="input-field">
                <input type="text" name="organization" id="organization" value="{{ request('organization') }}">
                <label for="organization">Organization</label>
            </div>
        </div>
        <div class="col s6 m3 input-field">
            <div class="input-field">
                <input type="text" name="location" id="location" value="{{ request('location') }}">
                <label for="location">Location</label>
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
@endsection
