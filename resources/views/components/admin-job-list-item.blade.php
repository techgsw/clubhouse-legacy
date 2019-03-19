<div class="row job-admin">
    <div class="col s3 m2">
        <a href="/job/{{$job->id}}" class="no-underline">
            @if (!is_null($job->image))
            <img src={{ $job->image->getURL('medium') }} class="no-border">
            @endif
        </a>
    </div>
    <div class="col s9 m10">
        <div class="small" style="float: right;">
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
        <a href="/job/{{$job->id}}">
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
                    <!--<span class="small flat-button red inverse" style="letter-spacing: 0.6px;"><b>Featured</b></span>-->
                @endif
                @if (is_null($job->open))
                    <span class="small flat-button black inverse">Not open</span>
                @elseif ($job->open == false)
                    <span class="small flat-button red inverse">Closed</span>
                @else
                    <span class="small flat-button green inverse">Open</span>
                @endif
                
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
                        <a href="/job/{{ $job->id }}#applications" class="small flat-button black inverse">{{ count($job->inquiries)  == 1 ? "1 inquiry" : count($job->inquiries) . " inquiries" }}</a>      
                        <a href="/job/{{ $job->id }}?step={{$step->id}}&sort=recent#applications" class="small flat-button {{ ((count($count) > 0) ? 'red' : 'black') }}">{{$step->name}}: {{ $count }}</a>                    
                        <a href="/job/{{ $job->id }}#applications" class="small flat-button grey inverse">{{ count($job->assignments)  == 1 ? "1 assignment" : count($job->assignments) . " assignments" }}</a>
                        @php
                            $count = 0;
                        @endphp
                        @if (array_key_exists($step->name , $job->contactAssignmentTotals()))
                            @php
                                $count = $job->contactAssignmentTotals()[$step->name];
                            @endphp
                        @endif
                        <a href="/job/{{ $job->id }}?step={{$step->id}}&sort=recent#applications" class="small flat-button {{ ((count($count) > 0) ? 'red' : 'black') }}">{{$step->name}}: {{ $count }}</a>
                        <br/>
                        <br/> 
                    @else
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
                        <a href="/job/{{ $job->id }}?step={{$step->id}}&sort=recent#applications" class="small flat-button black">{{$step->name}}: {{ $count }}</a>
                    @endif
                @endforeach  
            </p>
        @endcan
    </div>
</div>
