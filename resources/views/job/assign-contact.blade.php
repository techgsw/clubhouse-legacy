@foreach ($jobs as $job)
    <div class="row job-index {{ $job->featured ? 'featured-job' : '' }}">
        <div class="col s3 m2 center-align">
            <a target="_blank" href="{{ $job->getURL() }}" class="no-underline">
                @if (!is_null($job->image))
                    <img style="margin-top: 12px;" src={{ $job->image->getURL('medium') }} class="thumb">
                @endif
            </a>
        </div>
        <div class="col s9 m7">
            <a target="_blank" href="{{ $job->getURL() }}">
                <h5>{{ $job->title }}</h5>
                <p style="font-size: 16px; letter-spacing: .6px; font-weight: 700; margin: 0 0 6px 0;">{{ $job->organization_name }}</p>
                <p style="margin: 0 0 6px 0;"><i class="fa fa-map-pin icon-left" aria-hidden="true"></i>{{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
                <p class="small tags">
                    @if ($job->isNew())
                        <span class="label blue white-text" style="letter-spacing: 0.6px;"><b>NEW</b></span>
                    @endif
                </p>
            </a>
        </div>
        <div class="col s12 m3">
            <form id="assign-contact-job">
                {{ csrf_field() }}
            </form>
            @if (is_null($job->job_id))
                <button class="contact-job-assignment-btn btn sbs-red small" contact-id="{{ $contact_id }}" job-id="{{ $job->id }}">Assign to job</button>
                <p class="assigned-by hidden"><strong>Assigned by:</strong> <span class="admin-name"></span></p>
                <p class="assigned-at hidden"><strong>At:</strong> <span class="assigned-date"></span></p>
            @else
                <button class="contact-job-unassignment-btn btn blue lighten-1 small" contact-id="{{ $contact_id }}" job-id="{{ $job->id }}">Unassign Job</button>
                <p class="assigned-by"><strong>Assigned by:</strong> <span class="admin-name">{{ $job->first_name }} {{ $job->last_name }}</span></p>
                <p class="assigned-at"><strong>At:</strong> <span class="assigned-date">{{ $job->created_at }}</span></p>
            @endif
        </div>
    </div>
@endforeach
