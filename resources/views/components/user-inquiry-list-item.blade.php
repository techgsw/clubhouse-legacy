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
                <button data-action="inquiry-pipeline" {{ $inquiry->pipeline_id < 3 ? 'disabled' : '' }} data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="backward" class="flat-button small {{ $inquiry->pipeline_id < 3 ? 'gray' : 'blue' }}"><i class="fa fa-backward"></i></button>
                @if ($inquiry->pipeline_id == 1 && $inquiry instanceof App\Inquiry)
                    <button data-action="" data-comm-type="negative" data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button"><i class="fa fa-envelope"></i>&nbsp;<i class="fa fa-thumbs-down"></i></button>
                @endif
                <button data-action="" data-comm-type="none" data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button no-comm"><i class="fa fa-thumbs-down"></i></button>                    
                <button data-action="inquiry-pipeline" data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="pause" class="flat-button small blue {{$inquiry->status == 'paused' ? 'inverse' : ''}}"><i class="fa fa-question-circle"></i></button>
                <button data-action="inquiry-pipeline" data-comm-type="cold"{{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'blue' : 'gray' }} cold-comm"><i class="fa fa-envelope {{$inquiry->pipeline_id > 1 || !$inquiry instanceof App\Inquiry ? 'hidden' : ''}}"></i>{{$inquiry->pipeline_id < 2 || !$inquiry instanceof App\Inquiry  ? '&nbsp;' : ''}}<i class="fa fa-thumbs-up"></i><span class="thumbs-up-text">{{ $inquiry->pipeline_id < 2 && !$inquiry instanceof App\Inquiry ? ' Cold' : '' }}</span></button>
                @if ($inquiry->pipeline_id < 2 && !$inquiry instanceof App\Inquiry)
                    <button data-action="inquiry-pipeline" data-comm-type="warm" {{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="contact" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'orange' : 'gray' }} warm-comm"><i class="fa fa-thumbs-up"></i> Warm</button>                
                @endif

                <button data-action="inquiry-pipeline" data-comm-type="none"{{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'blue' : 'gray' }} {{$inquiry->pipeline_id > 1 ? 'hidden' : ''}} no-comm"><i class="fa fa-thumbs-up"></i><span class="thumbs-up-text "></span> {{$inquiry instanceof App\Inquiry  ? '' : 'None'}}</button>
                <form id="assign-contact-job">
                    {{ csrf_field() }}
                </form>
                <br />
                @if ($inquiry->admin_user)
                    <button class="contact-job-unassignment-btn btn blue lighten-1 btn-small" style="padding: 0 1.3rem" contact-id="{{ $inquiry->contact_id }}" job-id="{{ $inquiry->job_id }}" data-button-group-id="{{$inquiry->contact_id}}-{{$inquiry->job_id}}">Unassign Job</button>
                    <p class="assigned-by small"><strong>Assigned by:</strong> <span class="admin-name">{{ $inquiry->admin_user->first_name }} {{ $inquiry->admin_user->last_name }}</span></p>
                @endif
                <p class="updated-at small"><strong>Updated:</strong> <span class="updated-date">{{ $inquiry->updated_at }}</span></p>
                <p class="assigned-at small"><strong>Created:</strong> <span class="assigned-date">{{ $inquiry->created_at }}</span></p>
            </div>
        @endcan
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <h6>{{ $inquiry->job->title }}</h6>
            <p><span class="heavy">{{ $inquiry->job->organization_name }}</span> in {{ $inquiry->job->city }}, {{ $inquiry->job->state }}</p>
            <button type="button" id="pipeline-label-{{ $inquiry->id }}"  class="flat-button small input-control {{$inquiry->pipeline_id != 1 || $inquiry instanceof App\Inquiry  ? '' : 'hidden'}}" input-id="step">{{$job_pipeline[$inquiry->pipeline_id-1]->name}}</button>
            <span> <button type="button" data-id="{{$inquiry->id}}" class="flat-button red small {{$inquiry->reason ? '' : 'hidden'}} input-control {{ ($inquiry instanceof App\ContactJob ? 'contact-job' : 'inquiry') }}-reason-note-button">{{ucwords($inquiry->reason)}}</button> </span>
        </a>
        @can ('edit-inquiry', $inquiry)
            <div class="hide-on-med-and-up controls">
                <button type="button" class="flat-button small blue view-{{ ($inquiry->admin_user ? 'contact-job' : 'inquiry') }}-notes-btn" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                <button data-action="inquiry-pipeline" {{ $inquiry->pipeline_id < 3 ? 'disabled' : '' }} data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="backward" class="flat-button small {{ $inquiry->pipeline_id < 3 ? 'gray' : 'blue' }}"><i class="fa fa-backward"></i></button>
                @if ($inquiry->pipeline_id == 1 && $inquiry instanceof App\Inquiry)
                    <button data-action="" data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button"><i class="fa fa-envelope"></i>&nbsp;<i class="fa fa-thumbs-down"></i></button>
                @endif
                <button data-action="" data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} {{$inquiry->pipeline_id < 2 ? '' : 'hidden'}} negative-pipeline-modal-button no-comm"><i class="fa fa-thumbs-down"></i></button>                        
                <button data-action="inquiry-pipeline" data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="pause" class="flat-button small blue {{$inquiry->status == 'paused' ? 'inverse' : ''}}"><i class="fa fa-question-circle"></i></button>
                <button data-action="inquiry-pipeline" data-comm-type="cold"{{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'blue' : 'gray' }} cold-comm"><i class="fa fa-thumbs-up {{!$inquiry instanceof App\Inquiry ? 'hidden' : ($inquiry->pipeline_id < 2 ? '' : 'hidden')}}"></i><span class="thumbs-up-text">{{ $inquiry->pipeline_id < 2 && !$inquiry instanceof App\Inquiry ? ' Cold' : '' }}</span></button>
                @if ($inquiry->pipeline_id < 2 && !$inquiry instanceof App\Inquiry)
                    <button data-action="inquiry-pipeline" data-comm-type="warm" {{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="contact" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'orange' : 'gray' }} warm-comm"><i class="fa fa-thumbs-up"></i> Warm</button>      
                    <button data-action="inquiry-pipeline" data-comm-type="none" data-type="{{ $inquiry ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small blue {{$inquiry->pipeline_id < 2 ? '' : 'hidden'}} no-comm"><i class="fa fa-thumbs-up"></i></button>
                @endif
                <!-- logic needed -->
                <button data-action="inquiry-pipeline" data-comm-type="cold"{{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="{{ $inquiry instanceof App\ContactJob ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'blue' : 'gray' }} cold-comm"><i class="fa fa-thumbs-up"></i><span class="thumbs-up-text ">{{ $inquiry->pipeline_id < 2 && !$inquiry instanceof App\Inquiry ? ' Cold' : '' }}</span></button>

                <form id="assign-contact-job">
                    {{ csrf_field() }}
                </form>
                <br/>
                @if ($inquiry->admin_user)
                    <button class="contact-job-unassignment-btn btn blue lighten-1 btn-small" style="padding: 0 1.3rem" contact-id="{{ $inquiry->contact_id }}" job-id="{{ $inquiry->job_id }}" data-button-group-id="{{$inquiry->contact_id}}-{{$inquiry->job_id}}">Unassign Job</button>
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
