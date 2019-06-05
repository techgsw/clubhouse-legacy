@extends('layouts.clubhouse')
@section('title', 'Job Board')
@section('hero')
    <div class="row hero bg-image job-board">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/job-board-white.png" />
            <h4 class="header">Sports Job Board</h4>
            <p>Here are some of the most sought-after jobs in sports. Apply today!</p>
        </div>
    </div>
@endsection
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
        <div class="col s12 6 input-field center-align">
            <a href="{{ Auth::user() ? '' : '\job\register' }}" class="btn sbs-red" style="margin-bottom: 12px;">Post your job for free now!</a>
        </div>
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
