@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} just asked a question:</p>
        <p><b>{{ $question->title }}</b></p>
        <p>{{ $question->body }}</p>
        <p><a href="{{ config('app.url') }}/question/{{ $question->id }}">Click here</a> to view and respond.</p>
    @endslot
@endcomponent
