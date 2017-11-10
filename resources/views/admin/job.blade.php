<!-- /resources/views/admin/job.blade.php -->
@extends('layouts.admin')
@section('title', 'Job Board')
@section('content')
@can ('create-job')
    <div class="row">
        <div class="col s12 input-field" style="display: flex; flex-flow: row;">
            <a href="/job/create" class="btn sbs-red" style="flex: 0 0 auto;">List a job</a>
            <span style="flex: 1 0 auto; margin-left: 16px; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF;line-height: 36px; padding: 0 2rem;">N jobs</span>
        </div>
    </div>
@endcan
<div id="job-search-form">
    @include('forms.admin-job-search')
</div>
<div class="row">
    <div class="col s12">
        @if (count($jobs) > 0)
            @foreach ($jobs as $job)
                <div class="row job-admin">
                    <div class="col s3 m2">
                        <a href="/job/{{$job->id}}" class="no-underline">
                            <img src={{ Storage::disk('local')->url($job->image_url) }} class="no-border">
                        </a>
                    </div>
                    <div class="col s9 m10">
                        <p class="small" style="float: right; display: inline-block;">
                            @can ('close-job', $job)
                                @if (is_null($job->open) || $job->open == false)
                                    <a href="/job/{{ $job->id }}/open" class="spaced green-text"><i class="fa fa-check"></i> Open</a>
                                @endif
                                @if (is_null($job->open) || $job->open == true)
                                    <a href="/job/{{ $job->id }}/close" class="spaced red-text"><i class="fa fa-ban"></i> Close</a>
                                @endif
                            @endcan
                            @can ('edit-job', $job)
                                <a href="/job/{{ $job->id }}/edit" class="spaced blue-text"><i class="fa fa-pencil"></i> Edit</a>
                            @endcan
                        </p>
                        <a href="/job/{{$job->id}}">
                            <h5>{{ $job->title }}</h5>
                            <p><span class="heavy">{{ $job->organization }}</span> in {{ $job->city }}, {{ $job->state }}</p>
                        </a>
                        <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
                        @can ('close-job', $job)
                            @if (is_null($job->open))
                                <p class="small heavy" style="padding-top: 6px;">
                                    {{ $inquiries = count($job->inquiries) }}
                                    <span class="label spaced">Not open</span><span class="label spaced">{{ count($job->inquiries) == 1 ? "1 inquiry" : count($job->inquiries) . " inquiries" }}</span>
                                </p>
                            @elseif ($job->open == false)
                                <p class="small heavy" style="padding-top: 6px;">
                                    <span class="label spaced">Closed</span><span class="label spaced">{{ count($job->inquiries) == 1 ? "1 inquiry" : count($job->inquiries) . " inquiries" }}</span>
                                </p>
                            @else
                                <p class="small heavy" style="padding-top: 6px;">
                                    <span class="label spaced">Open</span><span class="label spaced">{{ count($job->inquiries) == 1 ? "1 inquiry" : count($job->inquiries) . " inquiries" }}</span>
                                </p>
                            @endif
                        @endcan
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col s12 center-align">
                    {{ $jobs->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
