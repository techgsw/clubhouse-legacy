@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>You requested mentorship from {{ $mentor->contact->getName() }}. We will reach out to you soon to schedule a meeting.</p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
