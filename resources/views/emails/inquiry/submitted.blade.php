@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for inquiring about the {{ $job->title }} position with {{ $job->organization }}. We've received your résumé, which we're passing along to our partners for review.</p>
        <p><a href="{{ config('app.url') }}job/{{ $job->id }}">Click here</a> to return to the job listing and view your application.</p>
        <p>We're committed to helping you succeed, so we're looking forward to helping you land the job you've always wanted.</p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
