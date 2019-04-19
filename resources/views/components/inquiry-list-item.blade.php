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
                <a style="margin: 2px 0;" class="no-underline" href="{{ ($inquiry->user ? '/user/'.$inquiry->user->id : '/contact/'.$inquiry->contact->id) }}">{{ $inquiry->user ? $inquiry->name : $inquiry->contact->getName() }}</a>
                @include('components.pipeline-labels')
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
                    @include('components.pipeline-controls')
                </div>
            @endcan
        </div>
    </div>
</div>
