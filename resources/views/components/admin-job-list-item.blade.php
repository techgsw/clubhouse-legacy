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
                    <a href="/job/{{ $job->id }}/open" class="small flat-button green"><i class="fa fa-arrow-circle-up"></i> Open</a>
                @endif
                @if (is_null($job->open) || $job->open == true)
                    <a href="/job/{{ $job->id }}/close" class="small flat-button red"><i class="fa fa-ban"></i> Close</a>
                @endif
            @endcan
            @can ('edit-job', $job)
                <a href="/job/{{ $job->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
        </p>
        <a href="/job/{{$job->id}}">
            <h5>{{ $job->title }}</h5>
            <p><span class="heavy">{{ $job->organization }}</span> in {{ $job->city }}, {{ $job->state }}</p>
        </a>
        <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
        @can ('close-job', $job)
            <p class="small heavy" style="padding-top: 6px;">
                @if (is_null($job->open))
                    <span class="spaced small flat-button black inverse">Not open</span>
                @elseif ($job->open == false)
                    <span class="small flat-button red spaced inverse">Closed</span>
                @else
                    <span class="small flat-button green spaced inverse">Open</span>
                @endif
                <a href="/job/{{ $job->id }}#applications" class="small flat-button black inverse">{{ count($job->inquiries) == 1 ? "1 inquiry" : count($job->inquiries) . " inquiries" }}</a>
                <a href="/job/{{ $job->id }}?rating=none&sort=recent#applications" class="small flat-button black"><i class="fa fa-circle-thin"></i> {{ $job->inquiryTotals()['none'] }}</a>
                <a href="/job/{{ $job->id }}?rating=up&sort=recent#applications" class="small flat-button black"><i class="fa fa-thumbs-up"></i> {{ $job->inquiryTotals()['up'] }}</a>
                <a href="/job/{{ $job->id }}?rating=maybe&sort=recent#applications" class="small flat-button black"><i class="fa fa-question-circle"></i> {{ $job->inquiryTotals()['maybe'] }}</a>
                <a href="/job/{{ $job->id }}?rating=down&sort=recent#applications" class="small flat-button black"><i class="fa fa-thumbs-down"></i> {{ $job->inquiryTotals()['down'] }}</a>
            </p>
        @endcan
    </div>
</div>
