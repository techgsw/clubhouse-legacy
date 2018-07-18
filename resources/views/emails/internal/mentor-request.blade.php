@component('emails.layout')
    @slot('body')
        <p><a href="{{ config('app.url') }}/user/{{ $user->id }}/profile">{{ $user->getName() }}</a> (<a href="mailto::{{ $user->email }}">{{ $user->email }}</a>) requested a mentorship meeting with <a href="{{ config('app.url') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a> (<a href="mailto::{{ $mentor->contact->email }}">{{ $mentor->contact->email }}</a>) on the following dates:</p>
        <ul>
            @foreach ($dates as $date)
                <li>{{ $date->format('m/d/Y') }} at {{ $date->format('h:iA') }} PST</li>
            @endforeach
        </ul>
    @endslot
@endcomponent
