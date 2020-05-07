@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($question->user->first_name) }},</p>
        <p>{{ ucwords($answer->user->first_name.' '.$answer->user->last_name) }} just posted an answer to your question titled <b>{{ $question->title }}</b>:</p>
        <p>"{{ $answer->answer }}"</p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/{{$question->context}}/discussion/{{ $question->id }}">Click here</a> view your question and the community's answers.</p>
        <p>Thanks!<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
