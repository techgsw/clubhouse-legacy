@component('emails.layout')
    @slot('body')
        <p><a href="{{ config('app.url') }}/user/{{ $user->id }}/profile">{{ $user->getName() }}</a> (<a href="mailto::{{ $user->email }}">{{ $user->email }}</a>) requested a mentorship meeting with <a href="{{ config('app.url') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a> (<a href="mailto::{{ $mentor->contact->email }}">{{ $mentor->contact->email }}</a>) on the following dates:</p>
        <ul>
            @foreach ($dates as $date)
                <li>{{ $date->format('l m/d/Y') }} at {{ $date->format('h:iA') }}</li>
            @endforeach
        </ul>
        <p><a href="{{ config('app.url') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a> has the following preferred availability:</p>
        <ul>
            <li>{{ ucfirst($mentor->day_preference_1) }} {{ $mentor->time_preference_1 }}</li>
            <li>{{ ucfirst($mentor->day_preference_2) }} {{ $mentor->time_preference_2 }}</li>
            <li>{{ ucfirst($mentor->day_preference_3) }} {{ $mentor->time_preference_3 }}</li>
        </ul>
    @endslot
@endcomponent
