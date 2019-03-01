@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }},</p>
        <p>Thank you for visiting the SBS Job board and for being a member of the SBS community!</p>
        <p>You are receiving this message as a confirmation of your application for the <strong>{{ $inquiry->job->title }}</strong> position with the <strong>{{ $inquiry->job->organization_name }}</strong>.  After reviewing your resume, we’ve determined you to be a potential fit for this opportunity and have presented your information to the hiring manager.  Someone from the organization should be contacting you directly within the next few days to arrange next steps and further discuss the position.</p>
        <p>Please don’t hesitate to reach out with any questions and keep us posted on how things move forward in the process.</p>
        <p>Best of luck and we look forward to talking again soon!</p>
        <p>-{{ $user->first_name }} {{ $user->last_name }}</p>
    @endslot
@endcomponent
