@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for inquiring about the {{ $job->title }} position with the {{ $job->organization }}. We've received your résumé and you are currently being considered for the position.</p>
        <p><a href="{{ config('app.url') }}/job/{{ $job->id }}">Click here</a> to return to the job listing and view your application.</p>
        <p>We're committed to helping you succeed, so we're looking forward to helping you land your next job in sports.</p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
