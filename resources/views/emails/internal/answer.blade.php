@component('emails.layout')
    @slot('body')
	<p>Bob,</p>
	<p>Someone answered a question on the {{$context == 'same-here' ? '#SameHere' : ''}}{{$context == 'sales-vault' ? 'Sports Sales Vault' : ''}} discussion board:</p>
    <p><strong>Question:</strong> {{ $question->body }}</p>
    <p><strong>Answer:</strong> {{ $answer->answer }}</p>
    <p><a href="{{ env('CLUBHOUSE_URL') }}/{{$context}}/discussion/{{ $question->id }}">Click here</a> to view the question and review/remove the answer.</p>
    @endslot
@endcomponent
