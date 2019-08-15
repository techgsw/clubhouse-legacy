<div class="col s12 m9 offset-m3 job-inquiry">
    <div class="row" style="margin-bottom: 0;">
        <div class="col s12">
            @can ('review-inquiry', $inquiry)
                <div class="float-right">
                    @component('components.resume-button',
                        ['url' => ((!is_null($inquiry->resume))
                            ? $inquiry->resume
                            : (!is_null($inquiry->contact->user()->first()) ? $inquiry->contact->user()->first()->profile->resume_url : null)
                        )]
                    )@endcomponent
                    @can ('view-inquiry-notes')
                    <button class="view-contact-notes-btn flat-button small"
                        contact-id="{{ ($inquiry->user ? $inquiry->user->contact->id : $inquiry->contact->id) }}"
                        contact-name="{{ ($inquiry->user ? $inquiry->user->contact->getName() : $inquiry->contact->getName()) }}"
                        contact-follow-up="{{ ($inquiry->user ? ($inquiry->user->contact->follow_up_date ? $inquiry->user->contact->follow_up_date->format('Y-m-d') : '') : ($inquiry->contact->follow_up_date ? $inquiry->contact->follow_up_date->format('Y-m-d') : '')) }}">
                        {{ ($inquiry->user ? $inquiry->user->contact->getNoteCount() : $inquiry->contact->getNoteCount()) }} <i class="fa fa-comments"></i>
                    </button>
                    @endcan
                </div>
                @can ('review-inquiry-admin')
                    <a style="margin: 2px 0;" class="no-underline" href="{{ ($inquiry->user ? '/user/'.$inquiry->user->id : '/contact/'.$inquiry->contact->id) }}">{{ $inquiry->user ? $inquiry->name : $inquiry->contact->getName() }}</a>
                @else
                    <span style="margin: 2px 0;" class="no-underline">{{ $inquiry->user ? $inquiry->name : $inquiry->contact->getName() }}</a>
                @endcan
                @include('components.pipeline-labels')
                @if ($inquiry->job_interest_response_code == 'interested' || (get_class($inquiry) == 'App\Inquiry' && $inquiry->pipeline_id >= 2 && $inquiry->status != 'halted'))
                    <span> <button type="button" class="flat-button small green"><i class="fa fa-user"></i>&nbsp; Interested</button></span>
                @elseif (in_array($inquiry->job_interest_response_code, array('not_interested', 'dnc')))
                    <span> <button type="button" class="flat-button small red"><i class="fa fa-user"></i>&nbsp; Not Interested</button></span>
                @endif
                @if ($inquiry->user)
                    <p style="line-height: 1.25; margin: 3px 0;">{{ $inquiry->user->contact->getTitle() }}</p>
                @else
                    <p style="line-height: 1.25; margin: 3px 0;">{{ $inquiry->contact->getTitle() }}</p>
                @endif
                <!-- email -->
                <p style="margin: 2px 0;" class="small">
                    @if ($inquiry->email)
                        <a class="no-underline" href="mailto:{{ $inquiry->email }}">{{ $inquiry->email}}</a>
                    @else
                        <a class="no-underline" href="mailto:{{ $inquiry->contact->email }}">{{ $inquiry->contact->email }}</a>
                    @endif
                    @if ($inquiry->phone)
                        <a class="no-underline" href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone}}</a>
                    @else
                        @if ($inquiry->user)
                            <a class="no-underline" href="tel:{{ $inquiry->user->contact->phone }}">{{ $inquiry->user->contact->phone }}</a>
                        @else
                            <a class="no-underline" href="tel:{{ $inquiry->contact->phone }}">{{ $inquiry->contact->phone }}</a>
                        @endif
                    @endif
                </p>
                <!-- end email -->
                <!-- assigned/applied -->
                <p style="margin: 2px 0;" class="small">
                    <span>{{ ($contact ? 'assigned by '.$inquiry->admin_user->first_name.' at' : 'applied') }} {{ $inquiry->created_at->format('n/j/Y H:i:s') }}</span>
                    @if (!is_null($inquiry->rating))
                        <span>, {{ $inquiry->admin_user ? $inquiry->admin_user->first_name : '' }} replied {{ $inquiry->updated_at->format('n/j/Y H:i:s') }}</span>
                    @endif
                    @if ($inquiry->created_at != $inquiry->updated_at)
                        <span>, updated at {{ $inquiry->updated_at->format('n/j/Y H:i:s') }}</span>
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
