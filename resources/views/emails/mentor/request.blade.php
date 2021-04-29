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
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>We’ve received your request for a 1:1 mentorship phone call with {{ $mentor->contact->getName() }} at {{ $mentor->contact->organization }}, preferably on the following dates ({{ $timezones[$mentor->timezone] }}):</p>
        <ul>
            @foreach ($dates as $date)
                <li>{{ $date->format('m/d/Y') }} at {{ $date->format('h:iA') }}</li>
            @endforeach
        </ul>
        <p>We know you are looking forward to it, so here’s what will happen next:</p>
        <ul>
            <li>We will review your request and check with the mentor to confirm their current availability.</li>
            <li>Within three business days someone from <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> team will be back in touch via email with either: a calendar invite to schedule the session, OR with a note to find a different date/time based on the mentors updated availability.</li>
        </ul>
        <p>Your mentor is willing to take time out of their busy schedule to help you. They are open to sharing their experiences, expertise, and to discussing things that are important and hopefully helpful to your career. However, please understand that there may be certain information they cannot openly share. These sessions are not for trying to contact other members of their organization(s), and these calls are not job interviews. Please also be sure to funnel all questions and requests of the mentor through us so we can keep the correspondence organized and maintain the privacy of our mentors.</p>
        <p>This is a professional work related conversation and an opportunity to put your best foot forward. You never know what one conversation can lead to down the road! Please take this seriously and be punctual. We want to make sure both you and your mentor have an enjoyable and productive time together. Have fun! </p>

        <p>We will reach out to you soon to schedule a meeting.</p>
        <p>Thanks!<br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent
