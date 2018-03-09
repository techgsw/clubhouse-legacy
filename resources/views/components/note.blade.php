<div id="note-{{$note->id}}" class="note" note-id="{{$note->id}}">
    <p style="padding: 8px 12px; border-radius: 4px; background: #F5F5F5; margin: 0px 2px;">
        @can ('delete-note')
            <button class="delete-note-btn flat-button small float-right" contact-id="{{ $note->notable_id }}" note-id="{{ $note->id }}"><i class="fa fa-trash"></i></button>
        @endcan
        @if ($note->job_title)
            <a target="_blank" href="/job/{{ $note->job_id }}" class="no-underline" style="display: block; margin-bottom: 10px; padding-top: 7px; padding-bottom: 10px; font-size: 10px; text-transform: uppercase; border-bottom: 1px dashed #ccc;"><b>{{ $note->job_organization }}</b> {{ $note->job_title }}</a>
        @endif
        {!! nl2br($note->content) !!}
        {{ csrf_field() }}
    </p>
    <p style="margin: 0px 0px 12px 0px; padding: 4px 6px; color: #666; font-size: 10px; text-transform: uppercase; text-align: right;">{{ $note->user->getName() }} {{ $note->created_at->format('m/d/Y') }}</p>
</div>
