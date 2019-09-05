@component('emails.layout')
    @slot('body')
        <p>THIS IS A TEST EMAIL NOTIFICATION. PLEASE IGNORE.</p>
        <p>{{ ucwords($job_user->first_name) }},</p>
        <p>{{ ucwords($inquiry_user->first_name) }} {{ ucwords($inquiry_user->last_name) }} applied for <strong>{{ $job->title }}</strong></p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/job/{{ $job->id }}">Click here</a> to return to the job listing</p>
        <p>Placeholder text placeholder text blah blah</p>
        <p>Regards,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
