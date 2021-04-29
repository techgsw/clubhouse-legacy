@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }},</p>
        <p>Thank you for visiting theClubhouse® job board and for being a member of our community!</p>
        <p>You are receiving this message as a confirmation of your application for the <strong>{{ $inquiry->job->title }}</strong> position with the <strong>{{ $inquiry->job->organization_name }}</strong>. After reviewing your resume, we’ve determined you to be a potential fit for this opportunity and would like to move forward with the application process.</p>
        <p>Before presenting your information to the hiring manager I'd like to take a few minutes to talk with you about the position and answer any initial questions you may have on your end.  Please suggest a few times that work for you over the next few days and we can get something on the calendar to walk through next steps.</p>
        <p>Thanks again and I look forward to talking with you soon!</p>
        <p>-{{ $user->first_name }} {{ $user->last_name }}</p>
    @endslot
@endcomponent
