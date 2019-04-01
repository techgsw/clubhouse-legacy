<div class="row user-inquiry-list-item">
    <div class="col s3 m2">
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <img src={{ $inquiry->job->image->getURL('small') }} class="no-border job-image">
        </a>
    </div>
    <div class="col s9 m10 info">
        @can ('edit-inquiry', $inquiry)
            <div class="hide-on-small-only float-right controls">
                <button type="button" class="flat-button small blue view-{{ ($inquiry->admin_user ? 'contact-job' : 'inquiry') }}-notes-btn" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                <form id="assign-contact-job">
                    {{ csrf_field() }}
                </form>
                <br />
                @if ($inquiry->admin_user)
                    <button class="contact-job-unassignment-btn btn blue lighten-1 small" style="padding: 0 1.3rem" contact-id="{{ $inquiry->contact_id }}" job-id="{{ $inquiry->job_id }}" data-button-group-id="{{$inquiry->contact_id}}-{{$inquiry->job_id}}">Unassign Job</button>
                    <p class="assigned-by small"><strong>Assigned by:</strong> <span class="admin-name">{{ $inquiry->admin_user->first_name }} {{ $inquiry->admin_user->last_name }}</span></p>
                @endif
                <p class="assigned-at small"><strong>At:</strong> <span class="assigned-date">{{ $inquiry->created_at }}</span></p>
            </div>
        @endcan
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <h6>{{ $inquiry->job->title }}</h6>
            <p><span class="heavy">{{ $inquiry->job->organization_name }}</span> in {{ $inquiry->job->city }}, {{ $inquiry->job->state }}</p>
            <p class="small">{{ ($inquiry->admin_user ? 'assigned by '.$inquiry->admin_user->first_name.' at' : 'submitted') }} {{ $inquiry->created_at->format('n/j/Y g:ia') }}</p>
        </a>
        @can ('edit-inquiry', $inquiry)
            <div class="hide-on-med-and-up controls">
                <button type="button" class="flat-button small blue view-{{ ($inquiry->admin_user ? 'contact-job' : 'inquiry') }}-notes-btn" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                <form id="assign-contact-job">
                    {{ csrf_field() }}
                </form>
                <br/>
                @if ($inquiry->admin_user)
                    <button class="contact-job-unassignment-btn btn blue lighten-1 small" style="padding: 0 1.3rem" contact-id="{{ $inquiry->contact_id }}" job-id="{{ $inquiry->job_id }}" data-button-group-id="{{$inquiry->contact_id}}-{{$inquiry->job_id}}">Unassign Job</button>
                    <p class="assigned-by small"><strong>Assigned by:</strong> <span class="admin-name">{{ $inquiry->admin_user->first_name }} {{ $inquiry->admin_user->last_name }}</span></p>
                @endif
                <p class="assigned-at small"><strong>At:</strong> <span class="assigned-date">{{ $inquiry->created_at }}</span></p>
            </div>
        @endcan
    </div>
</div>
<style media="screen">
    .user-inquiry-list-item {
        display: block;
        padding: 10px 16px;
        border-bottom: 1px solid #EEE;
        margin: 0;
    }
    .user-inquiry-list-item img.job-image {
        width: 80px;
        max-width: 100%;
    }
    .user-inquiry-list-item .info p {
        margin: 4px 0px;
    }
    a.user-inquiry-list-item {}
    a.user-inquiry-list-item:hover {
        background-color: #FAFAFA;
        border-bottom: 1px solid #EB2935;
    }
</style>
