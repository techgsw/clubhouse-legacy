@component('emails.layout')
    @slot('body')
        <p>A new mentor request has just been booked through Calend.ly:</p>
        <ul>
            <li><b>Mentee:</b> <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">{{ $user->getName() }}</a></li>
            <li><b>Mentor:</b> <a href="{{ env('CLUBHOUSE_URL') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a></li>
        </ul>
        <p>-<span style="color:#EB2935">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
