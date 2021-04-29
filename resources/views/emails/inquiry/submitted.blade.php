@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for inquiring about the <strong>{{ $job->title }}</strong> position with the <strong>{{ $job->organization_name }}</strong>. We've received your résumé and you are currently being considered for the position.</p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/job/{{ $job->id }}">Click here</a> to return to the job listing and view your application.</p>
        <p>We're committed to helping you succeed, so we're looking forward to helping you land your next job in sports.</p>
        <p>Regards,<br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent
