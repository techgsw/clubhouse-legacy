@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry_user->first_name) }} {{ ucwords($inquiry_user->last_name) }} just applied for the <strong>{{ $job->title }}</strong> position with the <strong>{{ $job->organization->name }}</strong></p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/job/{{ $job->id }}">Click here</a> to view their application.</p>
    @endslot
@endcomponent
