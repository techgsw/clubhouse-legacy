@component('emails.layout')
    @slot('body')
        <p><a href="{{ env('CLUBHOUSE_URL') }}/contact/{{ $user->contact->id }}">{{ $user->getName() }}</a> just created a new organization: <a href="{{ env('CLUBHOUSE_URL') }}/organization/{{ $organization->id }}">{{ $organization->name }}</a>.</p>
    @endslot
@endcomponent
