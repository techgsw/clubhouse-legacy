@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>You requested a mentorship meeting with {{ $mentor->contact->getName() }}, preferably on the following dates:</p>
        <ul>
            @foreach ($dates as $date)
                <li>{{ $date->format('m/d/Y') }} at {{ $date->format('h:iA') }} PST</li>
            @endforeach
        </ul>
        <p>We will reach out to you soon to schedule a meeting.</p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
