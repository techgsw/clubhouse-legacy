<div class="row job-admin">
    <div class="col s3 m2 center">
        @if (!is_null($job->image))
        <a href="/job/{{$job->id}}" class="no-underline"><img src="{{ $job->image->getURL('medium') }}" class="no-border"></a>
        @endif
        @if ($job->job_type_id == 3)
            <span class="small flat-button blue-grey inverse heavy">Premium Job</span>
        @endif
        @if ($job->job_type_id == 4)
            <span class="small flat-button black inverse heavy">Platinum Job</span>
        @endif
    </div>
    <div class="col s9 m10">
        <div class="small right-align" style="float: right;">
            @cannot ('edit-job-featured-status')
                @if ($job->job_type_id == 2 && $job->job_status_id == JOB_STATUS_ID['open'])
                    <a href="javascript: void(0);" data-job-id="{{ $job->id }}" class="small flat-button green job-options-upgrade-btn"><i class="fa fa-arrow-circle-up"></i> Upgrade</a>
                @elseif ($job->job_type_id == 3 && $job->job_status_id == JOB_STATUS_ID['open'])
                    <a href="{{ $job_platinum_upgrade->getURL(false, 'checkout') }}/{{ $job->id }}" class="small flat-button green"><i class="fa fa-arrow-circle-up"></i> Upgrade</a>
                @endif
            @endcan
            @can ('close-job', $job)
                @if (is_null($job->job_status_id) || $job->job_status_id == JOB_STATUS_ID['closed'])
                    <a href="/job/{{ $job->id }}/open" class="small flat-button green"><i class="fa fa-arrow-circle-up"></i> Open</a>
                @endif
                @if (is_null($job->job_status_id) || $job->job_status_id == JOB_STATUS_ID['open'])
                    <a href="/job/{{ $job->id }}/close" class="small flat-button red"><i class="fa fa-ban"></i> Close</a>
                @endif
            @endcan
            @can ('edit-job', $job)
                @if ($job->job_status_id == JOB_STATUS_ID['expired'] && Auth::user()->cannot('edit-expired-job'))
                    <a class="small flat-button grey tooltipped" disabled="true" data-tooltip="You cannot edit expired jobs"><i class="fa fa-pencil"></i> Edit</a>
                @else
                    <a href="/job/{{ $job->id }}/edit" class="small flat-button blue" ><i class="fa fa-pencil"></i> Edit</a>
                @endif
            @endcan
            <p style="font-size: 14px; font-weight: 400;">{{ $job->getTimeRemainingString() }}</p>
        </div>
        <a href="/job/{{$job->id}}">
            <h5>{{ $job->title }}</h5>
            <p><span class="heavy">{{ $job->organization_name }}</span> in {{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
        </a>
        <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
        @can ('close-job', $job)
            <p class="small heavy" style="padding-top: 6px;">
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

                <span class="small flat-button black inverse">{{ count($job->inquiries) + count($job->assignments) }}</span>
                
                @foreach ($job_pipeline as $step)
                    @php
                        $count = 0;
                    @endphp
                    @if ($step->id == 1)
                        @if (array_key_exists($step->name , $job->inquiryTotals()))
                            @php
                                $count = $job->inquiryTotals()[$step->name];
                            @endphp
                        @endif
                        <a href="/job/{{ $job->id }}?step={{$step->id}}&sort=recent#applications" class="small flat-button {{ (($count > 0) ? 'red' : 'black') }}" style="margin-bottom: 5px;">{{$step->name}}: {{ $count }}</a>                    
                        @php
                            $count = 0;
                        @endphp
                        @if (array_key_exists($step->name , $job->contactAssignmentTotals()))
                            @php
                                $count = $job->contactAssignmentTotals()[$step->name];
                            @endphp
                        @endif
                        <a href="/job/{{ $job->id }}?step={{$step->id}}&sort=recent#applications" class="small flat-button {{ (($count > 0) ? 'red' : 'black') }}" style="margin-bottom: 5px;">Assigned: {{ $count }}</a>
                    @elseif ($step->id == 2)
                        @if (array_key_exists($step->name , $job->inquiryTotals()))
                            @php
                                $count = $job->inquiryTotals()[$step->name]; 
                            @endphp
                        @endif
                        @if (array_key_exists($step->name , $job->contactAssignmentTotals()))
                            @php
                                $count += $job->contactAssignmentTotals()[$step->name];
                            @endphp
                        @endif
                        <a href="/job/{{ $job->id }}?step={{$step->id}}&sort=recent#applications" class="small flat-button black" style="margin-bottom: 5px;">{{$step->name}}: {{ $count }}</a>
                    @endif
                @endforeach  
            </p>
        @endcan
    </div>
</div>
