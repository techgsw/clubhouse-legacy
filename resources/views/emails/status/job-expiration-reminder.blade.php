@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for posting your job on <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> job board!  We wanted to remind you that your posting is going to expire <strong>in {{$number_of_days}} days.</strong></p>
        <p>If you would like more time to identify the right fit for the job, you are welcome to extend your listing for 30 days for FREE through your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{$user->id}}/job-postings">Job Postings</a> page.</p>
        <p>If that isn’t of interest, we hope that you come back to post your open jobs with us again in the future.</p>
        <p>If you have any questions for <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> and SBS team, feel free to reach out anytime at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>. Thanks again and hope to hear from you soon!</p>
        <p>Regards,<br/>SBS Consulting</p>
    @endslot
@endcomponent
