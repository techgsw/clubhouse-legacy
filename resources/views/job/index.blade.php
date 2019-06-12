@extends('layouts.clubhouse')
@section('title', 'Job Board')
@section('hero')
    <div class="row hero bg-image job-board">
        <div class="col s12">
            <h4 class="header">Sports Industry Job Board</h4>
            <p>Are you a recruiter or employer and want to post your job now? Click here.</p>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="card-flex-container">
            @php $i = 0; @endphp
            @foreach ($jobs as $job)
                @if ($i < 3)
                    <div class="card medium">
                        <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                            <div class="col s12 center" style="">
                                @if (!is_null($job->image))
                                    <img style="height: 100px;" src={{ $job->image->getURL('medium') }} class="thumb">
                                @endif
                            </div>
                            <div class="col s12 center" style="">
                                <h5 style="font-size: 18px;">{{ $job->title }}</h5>
                                <p style="font-size: 14px; letter-spacing: .6px; font-weight: 700; margin: 0 0 6px 0;">{{ $job->organization_name }}</p>
                                <p style="margin: 0 0 6px 0; font-size: 12px;"><i class="fa fa-map-pin icon-left" aria-hidden="true"></i>{{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
                                <p class="small tags">
                                    @if ($job->isNew())
                                        <span class="label blue white-text" style="letter-spacing: 0.6px;"><b>NEW</b></span>
                                    @endif
                                </p>
                                @can ('create-inquiry')
                                    <a style="margin-top: 12px;" href="{{ $job->getURL() }}" class="btn white black-text">Apply now</a>
                                @else
                                    <a style="margin-top: 12px;" href="/register" class="btn white black-text">Join to apply</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endif
                @php $i++; @endphp
            @endforeach
        </div>
    </div>
    <div style="margin-bottom: 12px;">
        <button class="text grey-text show-hide-sm hide-on-med-and-up" show-hide-id="job-search-form">
            <span class="show-options {{ $searching ? 'hidden' : ''}}"><i class="fa fa-caret-square-o-down icon-left"></i>Show search options</span>
            <span class="hide-options {{ $searching ? '' : 'hidden'}}"><i class="fa fa-caret-square-o-up icon-left"></i>Hide search options</span>
        </button>
    </div>
    <div class="row">
        <div class="col s12 6 input-field center-align">
            <a href="{{ Auth::user() ? '/job-options' : '/register?job=true' }}" class="btn sbs-red" style="margin-bottom: 12px;">Post your job for free now!</a>
        </div>
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
            <!--<div style="border: 3px solid #EB2935; border-radius: 4px; margin-bottom: 16px; padding: 0;">
                <h3 style="text-transform: uppercase; letter-spacing: 0.6px; font-size: 16px; color: #EB2935; margin: 0; padding: 20px 0 18px 18px;">Featured jobs</h3>-->
        @endif
        @foreach ($jobs as $job)
            @if ($featured && !$job->featured)
                @php
                    $featured = false;
                @endphp
                <!--</div>-->
            @endif
            @include('components.job-list-item', ['job' => $job])
        @endforeach
        @if ($featured)
            @php
                $featured = false;
            @endphp
            </div>
        @endif
        <div class="row">
            <div class="col s12 center-align">
                {{ $jobs->appends(request()->all())->links('components.pagination') }}
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
