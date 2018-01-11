@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} just applied for the {{ $job->title }} position with the {{ $job->organization }}</p>
        <p><a href="{{ config('app.url') }}/job/{{ $job->id }}">Click here</a> to view their application.</p>
    @endslot
@endcomponent
