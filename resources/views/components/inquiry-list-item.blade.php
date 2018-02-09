<div class="col s12 m9 offset-m3 job-inquiry">
    <div class="row" style="margin-bottom: 0;">
        <div class="col s12">
            <div class="float-right">
                @component('components.resume-button', ['url' => $inquiry->resume])@endcomponent
                <button class="view-contact-notes-btn flat-button small" contact-id="{{ $inquiry->user->contact->id }}">{{ $inquiry->user->contact->getNoteCount() }} <i class="fa fa-comments"></i></button>
            </div>
            <a style="margin: 2px 0;" class="no-underline block" href="/user/{{ $inquiry->user->id }}">{{ $inquiry->name}}</a>
            <p style="margin: 2px 0;" class="small">
                <a class="no-underline" href="mailto:{{ $inquiry->email}}">{{ $inquiry->email}}</a>
            </p>
            <p style="margin: 2px 0;" class="small">
                <span>applied {{ $inquiry->created_at->format('n/j/Y') }}</span>
                @if (!is_null($inquiry->rating))
                    <span>, replied {{ $inquiry->updated_at->format('n/j/Y') }}</span>
                @endif
            </p>
            @can ('edit-inquiry', $inquiry)
                <div style="margin: 4px 0;">
                    <button class="view-inquiry-notes-btn flat-button small blue" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                    <button action="inquiry-rate" inquiry-id="{{ $inquiry->id }}" rating="1" class="flat-button small blue {{ $inquiry->rating > 0 ? "inverse" : "" }}"><i class="fa fa-thumbs-up"></i></button>
                    <button action="inquiry-rate" inquiry-id="{{ $inquiry->id }}" rating="0" class="flat-button small blue {{ $inquiry->rating === 0 ? "inverse" : "" }}"><i class="fa fa-question-circle"></i></button>
                    <button action="inquiry-rate" inquiry-id="{{ $inquiry->id }}" rating="-1" class="flat-button small blue {{ $inquiry->rating < 0 ? "inverse" : "" }}"><i class="fa fa-thumbs-down"></i></button>
                </div>
            @endcan
        </div>
    </div>
</div>
