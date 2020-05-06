@component('emails.layout')
    @slot('body')
        <p>Someone just asked a question on the {{$context == 'same-here' ? '#SameHere' : ''}}{{$context == 'sales-vault' ? 'Sports Sales Vault' : ''}} discussion board:</p>
        <p><b>{{ $question->title }}</b></p>
        <p>{{ $question->body }}</p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/{{$context}}/discussion/{{ $question->id }}">Click here</a> to view, remove or respond.</p>
    @endslot
@endcomponent
