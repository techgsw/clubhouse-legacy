@if (count($notes) == 0)
    <div class="row">
        <div class="col s12">
            <p style="font-style: italic;">No notes</p>
        </div>
    </div>
@else
    <div class="row">
        <div class="col s12">
            @foreach ($notes as $note)
                <p style="padding: 8px 12px; border-radius: 4px; background: #F5F5F5; margin: 0px 2px;">
                    @can ('create-contact-note')
                        <button class="delete-note-btn flat-button small float-right" contact-id="{{ $note->notable_id }}" note-id="{{ $note->id }}"><i class="fa fa-trash"></i></button>
                    @endcan
                    @if ($note->job_title)
                        <a target="_blank" href="/job/{{ $note->job_id }}" class="no-underline" style="display: block; margin-bottom: 10px; padding-top: 7px; padding-bottom: 10px; font-size: 10px; text-transform: uppercase; border-bottom: 1px dashed #ccc;"><b>{{ $note->job_organization }}</b> {{ $note->job_title }}</a>
                    @endif
                    {!! nl2br($note->content) !!}

                </p>
                <form note-id="{{ $note->id }}">
                    {{ csrf_field() }}
                </form>
                <p style="margin: 0px 0px 12px 0px; padding: 4px 6px; color: #666; font-size: 10px; text-transform: uppercase; text-align: right;">{{ $note->user->getName() }} {{ $note->created_at->format('m/d/Y') }}</p>
            @endforeach
        </div>
    </div>
@endif
