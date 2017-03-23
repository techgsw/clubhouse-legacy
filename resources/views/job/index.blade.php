<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Job Board')
@section('content')
<div class="row">
    <div class="col s12 center-align">
        <h4>Job Board</h4>
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        <input id="search" type="text" name="search">
        <label for="search">Search</label>
    </div>
</div>
<div class="row">
    <div class="col s12">
        @if (count($jobs) > 0)
            @foreach ($jobs as $job)
                <a href="/job/{{ $job->id }}">
                    <div class="row job-index">
                        <div class="col s3 m2">
                            <img src={{ Storage::disk('local')->url($job->image_url) }} class="thumb">
                        </div>
                        <div class="col s9 m8">
                            <h5>{{ $job->title }}</h5>
                            <p>{{ $job->organization }} <i class="fa fa-map-pin spaced" aria-hidden="true"></i> {{ $job->city }}, {{ $job->state }}</p>
                            <p>listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
                        </div>
                        <div class="col s12 m2 center-align">
                            @can ('create-inquiry')
                                <a href="/job/{{ $job->id }}/inquire" class="btn sbs-red">Apply</a>
                            @else
                                <a href="/register" class="btn sbs-red">Register to apply</a>
                            @endcan
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <p class="light">No jobs yet! Check back soon.</p>
        @endif
    </div>
</div>
@endsection
