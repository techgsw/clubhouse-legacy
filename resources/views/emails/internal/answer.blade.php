@component('emails.layout')
    @slot('body')
	<p>Bob,</p>
	<p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} (<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>) answered a question.</p>
    <p><strong>Question:</strong> {{ $question->body }}</p>
    <p><strong>Answer:</strong> {{ $answer->answer }}</p>
    <p><a href="{{ config('app.url') }}/question/{{ $question->id }}">Click here</a> to view the question.</p>
    @endslot
@endcomponent
