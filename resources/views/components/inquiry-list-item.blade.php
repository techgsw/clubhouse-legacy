<div class="col s12 m9 offset-m3 job-inquiry">
    <div class="row" style="margin-bottom: 0;">
        <div class="col s12">
            @can ('edit-inquiry', $inquiry)
                <div class="float-right">
                    @component('components.resume-button', ['url' => $inquiry->resume])@endcomponent
                    <button class="view-contact-notes-btn flat-button small"
                        contact-id="{{ ($inquiry->user ? $inquiry->user->contact->id : $inquiry->contact->id) }}"
                        contact-name="{{ ($inquiry->user ? $inquiry->user->contact->getName() : $inquiry->contact->getName()) }}"
                        contact-follow-up="{{ ($inquiry->user ? ($inquiry->user->contact->follow_up_date ? $inquiry->user->contact->follow_up_date->format('Y-m-d') : '') : ($inquiry->contact->follow_up_date ? $inquiry->contact->follow_up_date->format('Y-m-d') : '')) }}">
                        {{ ($inquiry->user ? $inquiry->user->contact->getNoteCount() : $inquiry->contact->getNoteCount()) }} <i class="fa fa-comments"></i>
                    </button>
                </div>
                                
                <a style="margin: 2px 0;" class="no-underline" href="{{ ($inquiry->user ? '/user/'.$inquiry->user->id : '/contact/'.$inquiry->contact->id) }}">{{ $inquiry->user ? $inquiry->name : $inquiry->contact->getName() }}  <button type="button" id="pipeline-label-{{ $inquiry->id }}" class="flat-button small {{ request('step') == $step->id ? 'inverse' : '' }} {{!$contact ? '' : ($inquiry->pipeline_id != 1  ? '' : 'hidden')}} input-control" input-id="step" value='{{$step->id}}'>{{$job_pipeline[$inquiry->pipeline_id-1]->name}}</button></a>
                <span> <button type="button" data-id="{{$inquiry->id}}" class="flat-button red small {{$inquiry->reason ? '' : 'hidden'}} input-control {{ (!$contact ? 'inquiry' : 'contact-job') }}-reason-note-button">{{ucwords($inquiry->reason)}}</button> </span>
                
                <p style="margin: 2px 0;" class="small">
                    @if ($inquiry->email)
                        <a class="no-underline" href="mailto:{{ $inquiry->email}}">{{ $inquiry->email}}</a>
                    @else
                        <a class="no-underline" href="mailto:{{ $inquiry->contact->email}}">{{ $inquiry->contact->email }}</a>
                    @endif
                </p>
                <p style="margin: 2px 0;" class="small">
                    <span>{{ ($contact ? 'assigned by '.$inquiry->admin_user->first_name.' at' : 'applied') }} {{ $inquiry->created_at->format('n/j/Y') }}</span>
                    @if (!is_null($inquiry->rating))
                        <span>, {{ $inquiry->admin_user ? $inquiry->admin_user->first_name : '' }} replied {{ $inquiry->updated_at->format('n/j/Y') }}</span>
                    @endif
                </p>
                <div style="margin: 4px 0;">
                    <button class="view-{{ (!$contact ? 'inquiry' : 'contact-job') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                    <button data-action="inquiry-pipeline" {{ $inquiry->pipeline_id < 3 ? 'disabled' : '' }} data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="backward" class="flat-button small {{ $inquiry->pipeline_id < 3 ? 'gray' : 'blue' }}"><i class="fa fa-backward"></i></button>
                    @if ($inquiry->pipeline_id == 1 && !$contact)
                        <button data-action="" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button"><i class="fa fa-envelope"></i>&nbsp;<i class="fa fa-thumbs-down"></i></button>
                    @endif
                    <button data-action="" data-comm-type="none" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button no-comm"><i class="fa fa-thumbs-down"></i></i></button>
                    
                    <button data-action="inquiry-pipeline" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="pause" class="flat-button small blue {{$inquiry->status == 'paused' ? 'inverse' : ''}}"><i class="fa fa-question-circle"></i></button>
                    
                    
                    <button data-action="inquiry-pipeline" data-comm-type="cold"{{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'blue' : 'gray' }} cold-comm"><i class="fa fa-envelope {{$contact ? 'hidden' : ($inquiry->pipeline_id < 2 ? '' : 'hidden')}}"></i> {{$inquiry->pipeline_id < 2  ? '&nbsp;' : ''}}<i class="fa fa-thumbs-up"></i><span class="thumbs-up-text">{{ $inquiry->pipeline_id < 2 && $contact ? ' Cold' : '' }}</span></button>
                    @if ($inquiry->pipeline_id < 2 && !$contact)
                        <button data-action="inquiry-pipeline" data-comm-type="none" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small blue no-comm"><i class="fa fa-thumbs-up"></i></button>
                    @endif
                    @if ($inquiry->pipeline_id < 2 && $contact)
                        <button data-action="inquiry-pipeline" data-comm-type="warm" {{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="contact" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->pipeline_id < 6 ? 'orange' : 'gray' }} warm-comm"><i class="fa fa-thumbs-up"></i> Warm</button>
                        <button data-action="inquiry-pipeline" data-comm-type="none" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small blue no-comm"><i class="fa fa-thumbs-up"></i></button>
                    @endif
                    
                </div>
            @endcan
        </div>
    </div>
</div>
