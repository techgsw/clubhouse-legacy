@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for joining the Sports Business Solutions community! You’re now part of a group of both aspiring and current sports industry professionals who are committed to success in sports business. Congratulations on taking this step in your career.</p>
    @endslot
@endcomponent
