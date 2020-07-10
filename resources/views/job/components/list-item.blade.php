<div class="row job-admin">
    <div class="col s3 m2">
        <a href="/job/{{$job->id}}" class="no-underline">
            <img src={{ $job->image->getURL('medium') }} class="no-border">
        </a>
    </div>
    <div class="col s9 m10">
        <div class="small" style="float: right;">
            @can ('close-job', $job)
                @if (is_null($job->job_status_id) || $job->job_status_id == JOB_STATUS_ID['closed'])
                    <a href="/job/{{ $job->id }}/open" class="small flat-button green"><i class="fa fa-arrow-circle-up"></i> Open</a>
                @endif
                @if (is_null($job->job_status_id) || $job->job_status_id == JOB_STATUS_ID['open'])
                    <a href="/job/{{ $job->id }}/close" class="small flat-button red"><i class="fa fa-ban"></i> Close</a>
                @endif
            @endcan
            @can ('edit-job', $job)
                <a href="/job/{{ $job->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                @if ($job->featured)
                    <a href="/job/{{ $job->id }}/unfeature" class="flat-button small blue"><i class="fa fa-star"></i> {{ $job->rank }}</a>
                    <a href="/job/{{ $job->id }}/rank-top" class="flat-button small blue"><i class="fa fa-angle-double-up"></i></a>
                    <a href="/job/{{ $job->id }}/rank-up" class="flat-button small blue"><i class="fa fa-arrow-up"></i></a>
                    <a href="/job/{{ $job->id }}/rank-down" class="flat-button small blue"><i class="fa fa-arrow-down"></i></a>
                @else
                    <a href="/job/{{ $job->id }}/feature" class="flat-button small blue"><i class="fa fa-star-o"></i></a>
                @endif
            @endcan
        </div>
        <a href="/job/{{$job->id}}" target="_blank" rel="noopener">
            <h5>{{ $job->title }}</h5>
            <p><span class="heavy">{{ $job->organization_name }}</span> in {{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
        </a>
        <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
        @can ('close-job', $job)
            <p class="small heavy" style="padding-top: 6px;">
                @if ($job->isNew())
                    <span class="small flat-button blue inverse" style="letter-spacing: 0.6px;"><b>New</b></span>
                @endif
                @if ($job->featured)
                    <span class="small flat-button red inverse" style="letter-spacing: 0.6px;"><b>Featured</b></span>
                @endif
                @if (is_null($job->job_status_id))
                    <span class="small flat-button black inverse">Not open</span>
                @elseif ($job->job_status_id == JOB_STATUS_ID['closed'])
                    <span class="small flat-button red inverse">Closed</span>
                @elseif ($job->job_status_id == JOB_STATUS_ID['expired'])
                    <span class="small flat-button red inverse">Expired</span>
                @else
                    <span class="small flat-button green inverse">Open</span>
                @endif
                <a href="/job/{{ $job->id }}#applications" class="small flat-button black inverse">{{ count($job->inquiries) == 1 ? "1 inquiry" : count($job->inquiries) . " inquiries" }}</a>
                <a href="/job/{{ $job->id }}?rating=none&sort=recent#applications" class="small flat-button black"><i class="fa fa-circle-thin"></i> @php //{{ $job->inquiryTotals()['none'] }} @endphp</a>
                <a href="/job/{{ $job->id }}?rating=up&sort=recent#applications" class="small flat-button black"><i class="fa fa-thumbs-up"></i> @php //{{ $job->inquiryTotals()['up'] }} @endphp</a>
                <a href="/job/{{ $job->id }}?rating=maybe&sort=recent#applications" class="small flat-button black"><i class="fa fa-question-circle"></i> @php //{{ $job->inquiryTotals()['maybe'] }} @endphp</a>
                <a href="/job/{{ $job->id }}?rating=down&sort=recent#applications" class="small flat-button black"><i class="fa fa-thumbs-down"></i> @php //{{ $job->inquiryTotals()['down'] }} @endphp</a>
            </p>
        @endcan
    </div>
</div>
