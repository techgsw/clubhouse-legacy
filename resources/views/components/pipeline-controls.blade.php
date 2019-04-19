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
<button data-action="inquiry-pipeline" data-comm-type="none" data-type="{{ $contact ? 'contact' : 'user' }}" data-pipeline-id="{{ $inquiry->pipeline_id }}" data-id="{{ $inquiry->id }}" data-move="forward" class="flat-button small no-comm {{$inquiry->pipeline_id == 6 ? 'gray' : 'blue'}}" {{$inquiry->pipeline_id == 6 ? 'disabled' : ''}}><i class="fa fa-thumbs-up"></i><span class="thumbs-up-text">{{ $contact && $inquiry->pipeline_id < 2 && $inquiry->job->recruiting_type_code !== 'passive' ? ' None' : '' }}</span></button>
<!-- end forward no comm -->
