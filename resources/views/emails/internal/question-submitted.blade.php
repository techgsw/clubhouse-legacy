@component('emails.layout')
    @slot('body')
        <p>Someone just asked a question:</p>
        <p><b>{{ $question->title }}</b></p>
        <p>{{ $question->body }}</p>
        <p>This question is pending approval before being made public.</p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/question/{{ $question->id }}">Click here</a> to view, approve and respond.</p>
    @endslot
@endcomponent
