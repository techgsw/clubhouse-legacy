<!-- pipeline label -->
<button type="button" id="pipeline-label-{{ $inquiry->id }}" class="flat-button small input-control" input-id="step" value='{{ $inquiry->pipeline_id }}'>{{ ($contact && $inquiry->pipeline_id == 1) ? 'Assigned' : $job_pipeline[$inquiry->pipeline_id-1]->name }}</button></a>
<!-- end pipeline label -->
<!-- reason label -->
<span> <button type="button" data-id="{{$inquiry->id}}" data-type="{{ $contact ? 'contact' : 'user' }}" class="flat-button red small {{$inquiry->reason ? '' : 'hidden'}} input-control reason-note-button">{{ucwords($inquiry->reason)}}</button> </span>
<!-- end reason label -->
