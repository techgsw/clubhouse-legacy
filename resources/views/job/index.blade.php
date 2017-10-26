<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Job Board')
@section('content')
<div class="container">
    <div style="margin-bottom: 12px;">
        <button class="text grey-text show-hide" show-hide-id="job-search-form">
            <span class="show-options"><i class="fa fa-caret-square-o-down icon-left"></i>Show search options</span>
            <span class="hide-options hidden"><i class="fa fa-caret-square-o-up icon-left"></i>Hide search options</span>
        </button>
    </div>
    <div id="job-search-form" class="hidden">
        @include('forms.job-search')
    </div>
    @if (count($jobs) > 0)
        @if ($jobs[0]->featured)
            <h3 style="text-transform: uppercase; letter-spacing: 0.6px; font-size: 14px; color: #EB2935; border-left: 3px solid #EB2935; margin: 0; padding: 12px 0 18px 18px;">Featured jobs</h3>
        @endif
        @foreach ($jobs as $job)
            <a href="{{ $job->getURL() }}">
                <div class="row job-index {{ $job->featured ? 'featured-job' : '' }}">
                    <div class="col s3 m2 center-align">
                        <img style="margin-top: 12px;" src={{ Storage::disk('local')->url($job->image_url) }} class="thumb">
                    </div>
                    <div class="col s9 m7">
                        <h5>{{ $job->title }}</h5>
                        <p style="font-size: 16px; letter-spacing: .6px; font-weight: 700; margin: 0 0 6px 0;">{{ $job->organization }}</p>
                        <p style="margin: 0 0 6px 0;"><i class="fa fa-map-pin icon-left" aria-hidden="true"></i>{{ $job->city }}, {{ $job->state }}</p>
                        <p class="small tags">
                            @if ($job->isNew())
                                <span class="label blue white-text" style="letter-spacing: 0.6px;"><b><i class="fa fa-certificate icon-left" aria-hidden="true"></i>NEW</b></span>
                            @endif
                        </p>
                    </div>
                    <div class="col s12 m3 center-align hide-on-small-only">
                        @can ('create-inquiry')
                            <a style="margin-top: 12px;" href="{{ $job->getURL() }}" class="btn white black-text">Apply now</a>
                        @else
                            <a style="margin-top: 12px;" href="/register" class="btn white black-text">Join to apply</a>
                        @endcan
                    </div>
                </div>
            </a>
        @endforeach
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
