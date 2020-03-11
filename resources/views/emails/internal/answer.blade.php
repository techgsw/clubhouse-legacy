@component('emails.layout')
    @slot('body')
	<p>Bob,</p>
	<p>Someone answered a question.</p>
    <p><strong>Question:</strong> {{ $question->body }}</p>
    <p><strong>Answer:</strong> {{ $answer->answer }}</p>
    <p><a href="{{ env('CLUBHOUSE_URL') }}/same-here/discussion/{{ $question->id }}">Click here</a> to view the question and review/remove the answer.</p>
    @endslot
@endcomponent
