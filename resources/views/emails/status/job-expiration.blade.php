@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for posting your job on <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> job board!  We hope the process has been smooth and you've been able to connect with some quality candidates. If for some reason you haven't been able to identify the right fit for the job, you are welcome to extend your listing for another 30 days on the job board for {{$job->job_type_id == JOB_TYPE_ID['user_free'] ? 'just $250' : 'FREE'}}.</p>
        <p>If that isn’t of interest, we hope that you come back to post your open jobs with us again in the future.</p>
        <p>If you have any questions for <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> and SBS team, feel free to reach out anytime at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>. Thanks again and hope to hear from you soon!</p>
        <p>Regards,<br/>SBS Consulting</p>
    @endslot
@endcomponent
