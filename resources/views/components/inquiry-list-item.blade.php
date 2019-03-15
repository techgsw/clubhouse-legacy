<div class="col s12 m9 offset-m3 job-inquiry">
    <div class="row" style="margin-bottom: 0;">
        <div class="col s12">
            <div class="float-right">
                @component('components.resume-button', ['url' => $inquiry->resume])@endcomponent
                <button class="view-contact-notes-btn flat-button small"
                    contact-id="{{ ($inquiry->user ? $inquiry->user->contact->id : $inquiry->contact->id) }}"
                    contact-name="{{ ($inquiry->user ? $inquiry->user->contact->getName() : $inquiry->contact->getName()) }}"
                    contact-follow-up="{{ ($inquiry->user ? ($inquiry->user->contact->follow_up_date ? $inquiry->user->contact->follow_up_date->format('Y-m-d') : '') : ($inquiry->contact->follow_up_date ? $inquiry->contact->follow_up_date->format('Y-m-d') : '')) }}">
                    {{ ($inquiry->user ? $inquiry->user->contact->getNoteCount() : $inquiry->contact->getNoteCount()) }} <i class="fa fa-comments"></i>
                </button>
            </div>
            <a style="margin: 2px 0;" class="no-underline block" href="{{ ($inquiry->user ? '/user/'.$inquiry->user->id : '/contact/'.$inquiry->contact->id) }}">{{ $inquiry->user ? $inquiry->name : $inquiry->contact->getName() }}  <button type="button" class="flat-button small {{ request('step') == $step->id ? "inverse" : "" }} input-control" input-id="step" value='{{$step->id}}'>{{$job_pipeline[$inquiry->pipeline_id-1]->name}}</button></a>
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
            @can ('edit-inquiry', $inquiry)
                @php
                    //dd($inquiry);
                @endphp
                @if ($inquiry->contact_id > 0 && $inquiry->pipeline_id <= 1) 
                    <div style="margin: 4px 0;">
                        <button class="view-{{ ($contact ? 'contact-job' : 'inquiry') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                        <!-- class="flat-button small blue {{ $inquiry->rating < 0 ? "inverse" : "" }}" -->
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" rating="-1" class="flat-button small blue"><i class="fa fa-thumbs-down"></i></button>                    
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="halt" class="flat-button small blue"><i class="fa fa-question-circle"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="forward" class="flat-button small blue"><i class="fa fa-thumbs-up"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="forward" class="flat-button small orange"><i class="fa fa-thumbs-up"></i></button>                
                    </div>
                @elseif ($inquiry->pipeline_id <= 2)
                    <div style="margin: 4px 0;">
                        <button class="view-{{ ($contact ? 'contact-job' : 'inquiry') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                        <!-- class="flat-button small blue {{ $inquiry->rating < 0 ? "inverse" : "" }}" -->
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" rating="-1" class="flat-button small blue"><i class="fa fa-thumbs-down"></i></button>                    
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="halt" class="flat-button small blue"><i class="fa fa-question-circle"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="forward" class="flat-button small blue"><i class="fa fa-thumbs-up"></i></button>                
                    </div>
                @elseif ($inquiry->pipeline_id == 6)
                    <div style="margin: 4px 0;">
                            <button class="view-{{ ($contact ? 'contact-job' : 'inquiry') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                            <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="backward" class="flat-button small blue"><i class="fa fa-backward"></i></button>
                    </div>
                @elseif ($job_pipeline[count($job_pipeline)-1]->id == $inquiry->pipeline_id)
                    <div style="margin: 4px 0;">
                        <button class="view-{{ ($contact ? 'contact-job' : 'inquiry') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="backward" class="flat-button small blue"><i class="fa fa-backward"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" rating="-1" class="flat-button small blue"><i class="fa fa-thumbs-down"></i></button>                    
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="halt" class="flat-button small blue"><i class="fa fa-question-circle"></i></button>
                    </div>
                @else
                    <div style="margin: 4px 0;">
                        <button class="view-{{ ($contact ? 'contact-job' : 'inquiry') }}-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="backward" class="flat-button small blue"><i class="fa fa-backward"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" rating="-1" class="flat-button small blue"><i class="fa fa-thumbs-down"></i></button>                    
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="halt"class="flat-button small blue"><i class="fa fa-question-circle"></i></button>
                        <button action="inquiry-rate" data-type="{{ $contact ? 'contact' : 'user' }}" pipeline-id="{{$inquiry->pipeline_id}}" data-id="{{ $inquiry->id }}" move="forward" class="flat-button small blue"><i class="fa fa-thumbs-up"></i></button>                
                    </div>
                @endif
            @endcan
        </div>
    </div>
</div>
