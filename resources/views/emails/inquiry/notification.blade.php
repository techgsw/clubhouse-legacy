@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry_user->first_name) }} {{ ucwords($inquiry_user->last_name) }} just applied for the {{ $job->title }} position with the {{ $job->organization }}</p>
        <p><a href="{{ config('app.url') }}/job/{{ $job->id }}">Click here</a> to view their application.</p>
    @endslot
@endcomponent
