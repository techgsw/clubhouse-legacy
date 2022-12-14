@php
    $timezones = array(
        'hst' => 'Hawaii (GMT-10:00)',
        'akdt' => 'Alaska (GMT-09:00)',
        'pst' => 'Pacific Time (US & Canada) (GMT-08:00)',
        'azt' => 'Arizona (GMT-07:00)',
        'mst' => 'Mountain Time (US & Canada) (GMT-07:00)',
        'cdt' => 'Central Time (US & Canada) (GMT-06:00)',
        'est' => 'Eastern Time (US & Canada) (GMT-05:00)'
    );
@endphp
@component('emails.layout')
    @slot('body')
        <p>Exciting! You have a new mentorship request in <span style="color:#EB2935">the</span>Clubhouse<sup>&#174;</sup> below. Please email <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a> with which option works best for you and we'll get it scheduled.</p>
        <p>-<span style="color:#EB2935">the</span>Clubhouse<sup>&#174;</sup> Team</p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">{{ $user->getName() }}</a> (<a href="mailto::{{ $user->email }}">{{ $user->email }}</a>) requested a mentorship meeting with <a href="{{ env('CLUBHOUSE_URL') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a> (<a href="mailto::{{ $mentor->contact->email }}">{{ $mentor->contact->email }}</a>) on the following dates ({{ $timezones[$mentor->timezone] }}):</p>
        <ul>
            @foreach ($dates as $date)
                <li>{{ $date->format('l m/d/Y') }} at {{ $date->format('h:iA') }}</li>
            @endforeach
        </ul>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/contact/{{ $mentor->contact->id }}/mentor">{{ $mentor->contact->getName() }}</a> has the following preferred availability:</p>
        <ul>
            <li>{{ ucfirst($mentor->day_preference_1) }} {{ $mentor->time_preference_1 }}</li>
            <li>{{ ucfirst($mentor->day_preference_2) }} {{ $mentor->time_preference_2 }}</li>
            <li>{{ ucfirst($mentor->day_preference_3) }} {{ $mentor->time_preference_3 }}</li>
        </ul>
    @endslot
@endcomponent
