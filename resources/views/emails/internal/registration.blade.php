@component('emails.layout')
    @slot('body')
	<p>Bob,</p>
	<p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} (<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>) just registred.</p>
    @endslot
@endcomponent
