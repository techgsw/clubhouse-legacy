@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }},</p>
        <p>Thank you for visiting <span style="color: #EB2935;">the</span>job board and for being a member of our community!</p>
        <p>You are receiving this message as a confirmation of your application for the <strong>{{ $inquiry->job->title }}</strong> position with the <strong>{{ $inquiry->job->organization_name }}</strong>.  Unfortunately, after reviewing your resume against other applicants, you will not be advancing to the next stage in the process.</p>
        <p>Please be sure to continue to monitor our job board for future openings, and if you haven’t done so already, check out <a href="https://clubhouse.sportsbusiness.solutions"><span style="color: #EB2935;">the</span>Clubhouse</a> for additional resources as you continue to grow and take your sports business career to the next level.</p>
        <p>Best of luck and I look forward to talking again soon!</p>
        <p>Sincerely,</p>
        <p>The SBS and Clubhouse Team</p>
    @endslot
@endcomponent
