@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }},</p>
        <p>Thank you for visiting the SBS Job board and for being a member of the SBS community!</p>
        <p>You are receiving this message as a confirmation of your application for the {{ $inquiry->job->title }} position with the {{ $inquiry->job->organization_name }}.  Unfortunately, after reviewing your resume against other applicants our client is considering for the position, you will not be advancing to the next stage in the process.</p>
        <p>That being said, we’re actively supporting a few other opportunities that may be a better fit for your background and, while I wasn’t sure if there was a specific interest in this position, I would like to arrange a call over the next few days if you’d be open to exploring other options?</p>
        <p>Let me know what you think and please feel free to suggest some times the two of us can discuss further.  Thanks again and hope to talk soon!</p>
        <p>-{{ $user->first_name }} {{ $user->last_name }}</p>
    @endslot
@endcomponent
