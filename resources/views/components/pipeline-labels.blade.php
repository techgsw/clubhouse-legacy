<!-- pipeline label -->
<button type="button" id="pipeline-label-{{ $inquiry->id }}" class="flat-button small input-control" input-id="step" value='{{ $inquiry->pipeline_id }}'>{{ ($inquiry->pipeline_id == 1) ? 'Assigned' : Gate::allows('review-inquiry', $inquiry) ? $job_pipeline[$inquiry->pipeline_id-1]->name : 'Reviewed' }}</button></a>
<!-- end pipeline label -->
<!-- reason label -->
<span><button type="button" data-id="{{$inquiry->id}}" data-type="{{ $contact ? 'contact' : 'user' }}" class="flat-button red small {{$inquiry->reason ? '' : 'hidden'}} input-control reason-note-button"><i class="fa fa-thumbs-down @can('review-inquiry-admin') 'hidden' @endcan"></i>@cannot('review-inquiry-admin')&nbsp;@endcan<span class="reason-text">{{ucwords(str_replace('-', ' ', $inquiry->reason))}}</span></button></span>
<!-- end reason label -->
@cannot ('review-inquiry-admin')
        <button type="button" data-id="{{$inquiry->id}}" class="flat-button green small user-decision-positive {{ ($inquiry->status != 'halted' && $inquiry->pipeline_id > 1) ? '' : 'hidden' }}"><i class="fa fa-thumbs-up"></i></button></a>
@endcannot
