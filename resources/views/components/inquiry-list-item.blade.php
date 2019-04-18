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
                                
                
                <!-- pipeline label -->
                <a style="margin: 2px 0;" class="no-underline" href="{{ ($inquiry->user ? '/user/'.$inquiry->user->id : '/contact/'.$inquiry->contact->id) }}">{{ $inquiry->user ? $inquiry->name : $inquiry->contact->getName() }}  <button type="button" id="pipeline-label-{{ $inquiry->id }}" class="flat-button small {{ request('step') == $step->id ? 'inverse' : '' }} {{!$contact ? '' : ($inquiry->pipeline_id != 1  ? '' : 'hidden')}} input-control" input-id="step" value='{{$step->id}}'>{{$job_pipeline[$inquiry->pipeline_id-1]->name}}</button></a>
                <!-- end pipeline label -->
                <!-- reason label -->
                <span> <button type="button" data-id="{{$inquiry->id}}" data-type="{{ $contact ? 'contact' : 'user' }}" class="flat-button red small {{$inquiry->reason ? '' : 'hidden'}} input-control reason-note-button">{{ucwords($inquiry->reason)}}</button> </span>
                
                <!-- end reason label -->
                <!-- email -->
                <p style="margin: 2px 0;" class="small">
                    @if ($inquiry->email)
                        <a class="no-underline" href="mailto:{{ $inquiry->email}}">{{ $inquiry->email}}</a>
                    @else
                        <a class="no-underline" href="mailto:{{ $inquiry->contact->email}}">{{ $inquiry->contact->email }}</a>
                    @endif
                </p>
                <!-- end email -->
                <!-- assigned/applied -->
                <p style="margin: 2px 0;" class="small">
                    <span>{{ ($contact ? 'assigned by '.$inquiry->admin_user->first_name.' at' : 'applied') }} {{ $inquiry->created_at->format('n/j/Y') }}</span>
                    @if (!is_null($inquiry->rating))
                        <span>, {{ $inquiry->admin_user ? $inquiry->admin_user->first_name : '' }} replied {{ $inquiry->updated_at->format('n/j/Y') }}</span>
                    @endif
                </p>
                <!-- end assigned/applied -->
                <div style="margin: 4px 0;">
                    <!-- job specific notes -->
                    <button class="view-{{ (!$contact ? 'inquiry' : 'contact-job') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                    <!-- end job specific notes -->
                    <!-- backwards -->
                    <button data-action="inquiry-pipeline" {{ $inquiry->pipeline_id < 3 ? 'disabled' : '' }} data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="backward" class="flat-button small {{ $inquiry->pipeline_id < 3 ? 'gray' : 'blue' }}"><i class="fa fa-backward"></i></button>
                    <!-- end backwards -->
                    <!-- halt (thumbs down) comms for user -->
                    @if ($inquiry->pipeline_id == 1 && !$contact)
                        <button data-action="" data-type="user" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button default-comm"><i class="fa fa-envelope"></i>&nbsp;<i class="fa fa-thumbs-down"></i></button>
                    @endif
                    <!-- end halt (thumbs down) comms -->
                    <!-- halt (thumbs down) no comms -->
                    <button data-action="" data-comm-type="none" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="halt" class="flat-button small blue {{$inquiry->status == 'halted' ? 'inverse' : ''}} negative-pipeline-modal-button no-comm"><i class="fa fa-thumbs-down"></i></i></button>
                    
                    <!-- end halt (thumbs down) no comms -->
                    <!-- pause (?) -->
                    <button data-action="inquiry-pipeline" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="pause" class="flat-button small blue {{$inquiry->status == 'paused' ? 'inverse' : ''}}"><i class="fa fa-question-circle"></i></button>
                    <!-- end pause (?) -->
                    <!-- forward cold and warm -->
                    @if ($inquiry->pipeline_id < 2)
                        <button data-action="inquiry-pipeline" data-comm-type="{{ $contact ? 'cold' : 'default' }}" {{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{$inquiry instanceof App\ContactJob && $inquiry->job->recruiting_type_code == 'passive' ? 'hidden' : ''}} {{ $inquiry->pipeline_id < 6 ? 'blue' : 'gray' }} {{ $contact ? 'cold-comm' : ''}}"><i class="fa fa-envelope {{$contact ? 'hidden' : ($inquiry->pipeline_id < 2 ? '' : 'hidden')}}"></i>{{$inquiry->pipeline_id < 2  ? '&nbsp;' : ''}}<i class="fa fa-thumbs-up"></i><span class="thumbs-up-text">{{ $inquiry->pipeline_id < 2 && $contact ? ' Cold' : '' }}</span></button>
                        @if ($contact)
                            <button data-action="inquiry-pipeline" data-comm-type="warm" {{ $inquiry->pipeline_id < 6 ? '' : 'disabled' }} data-type="contact" data-pipeline-id="{{ $inquiry->pipeline_id }}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small {{ $inquiry->job->recruiting_type_code == 'passive' ? 'hidden' : '' }} {{ $inquiry->pipeline_id < 6 ? 'orange' : 'gray' }} warm-comm"><i class="fa fa-thumbs-up"></i> Warm</button>
                        @endif
                    @endif 
                    <!-- end forward cold and warm -->
                    <!-- forward no comm -->
                    <button data-action="inquiry-pipeline" data-comm-type="none" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{ $inquiry->pipeline_id }}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small no-comm {{$inquiry->pipeline_id == 6 ? 'gray' : 'blue'}}" {{$inquiry->pipeline_id == 6 ? 'disabled' : ''}}><i class="fa fa-thumbs-up"></i> {{ $contact && $inquiry->pipeline_id < 2 ? 'None' : '' }}</button>
                    <!-- end forward no comm -->
                </div>
            @endcan
        </div>
    </div>
</div>
