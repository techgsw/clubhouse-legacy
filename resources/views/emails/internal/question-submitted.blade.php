@component('emails.layout')
    @slot('body')
        <p>Someone just asked a question:</p>
        <p><b>{{ $question->title }}</b></p>
        <p>{{ $question->body }}</p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/same-here/discussion/{{ $question->id }}">Click here</a> to view, remove or respond.</p>
    @endslot
@endcomponent
