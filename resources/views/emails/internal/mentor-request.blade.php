@component('emails.layout')
    @slot('body')
        <p><a href="{{ config('app.url') }}/user/{{ $user->id }}/profile">{{ $user->getName() }}</a> (<a href="mailto::{{ $user->email }}">{{ $user->email }}</a>) requested mentorship from <a href="{{ config('app.url') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a> (<a href="mailto::{{ $mentor->contact->email }}">{{ $mentor->contact->email }}</a>)</p>
    @endslot
@endcomponent
