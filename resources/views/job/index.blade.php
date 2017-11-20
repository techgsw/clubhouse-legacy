<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Job Board')
@section('content')
<div class="container">
    <div style="margin-bottom: 12px;">
        <button class="text grey-text show-hide-sm hide-on-med-and-up" show-hide-id="job-search-form">
            <span class="show-options {{ $searching ? 'hidden' : ''}}"><i class="fa fa-caret-square-o-down icon-left"></i>Show search options</span>
            <span class="hide-options {{ $searching ? '' : 'hidden'}}"><i class="fa fa-caret-square-o-up icon-left"></i>Hide search options</span>
        </button>
    </div>
    <div id="job-search-form" class="{{ $searching ? '' : 'hide-on-small-only'}}">
        @include('forms.job-search')
    </div>
    @if (count($jobs) > 0)
        @php
            $featured = false;
        @endphp
        @if ($jobs[0]->featured)
            @php
                $featured = true;
            @endphp
            <div style="border: 3px solid #EB2935; border-radius: 4px; margin-bottom: 16px; padding: 0;">
                <h3 style="text-transform: uppercase; letter-spacing: 0.6px; font-size: 16px; color: #EB2935; margin: 0; padding: 20px 0 18px 18px;">Featured jobs</h3>
        @endif
        @foreach ($jobs as $job)
            @if ($featured && !$job->featured)
                @php
                    $featured = false;
                @endphp
                </div>
            @endif
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
                                <span class="label blue white-text" style="letter-spacing: 0.6px;"><b>NEW</b></span>
                            @endif
                        </p>
                    </div>
                    <div class="col s12 m3 center-align hide-on-small-only">
                        <div>
                            @can ('create-inquiry')
                                <a style="margin-top: 12px;" href="{{ $job->getURL() }}" class="btn white black-text">Apply now</a>
                            @else
                                <a style="margin-top: 12px;" href="/register" class="btn white black-text">Join to apply</a>
                            @endcan
                        </div>
                        @can ('edit-job', $job)
                            <div class="small" style="margin-top: 16px;">
                                <a href="/job/{{ $job->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i></a>
                                @if ($job->featured)
                                    <a href="/job/{{ $job->id }}/unfeature" class="flat-button small blue"><i class="fa fa-star"></i> {{ $job->rank }}</a>
                                    <a href="/job/{{ $job->id }}/rank-up" class="flat-button small blue"><i class="fa fa-arrow-up"></i></a>
                                    <a href="/job/{{ $job->id }}/rank-down" class="flat-button small blue"><i class="fa fa-arrow-down"></i></a>
                                @else
                                    <a href="/job/{{ $job->id }}/feature" class="flat-button small blue"><i class="fa fa-star-o"></i></a>
                                @endif
                            </div>
                        @endcan
                    </div>
                </div>
            </a>
        @endforeach
        @if ($featured)
            @php
                $featured = false;
            @endphp
            </div>
        @endif
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
