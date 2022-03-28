@component('emails.layout')
    @slot('body')
        <p>{{ucwords($user->first_name)}},</p>
        <p>Thank you for posting your job in <strong><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup></strong>! You'll be notified via email of any candidates who apply to your position.</p>
        <p>Here's a sharable link for your job posting that you can use on social media:</p>
        <p><a href="{{env('CLUBHOUSE_URL').$job->getUrl()}}">{{env('CLUBHOUSE_URL').$job->getUrl()}}</a></p>
        <h2>What's next?</h2>
        <p>You can view or edit your posting at any time on your <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/job-postings">Job Postings</a> page. You can also use this page to see if anyone has <strong>Applied</strong> to your job, or if a member of <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> team has <strong>Assigned</strong> a candidate to your job.</p>
        <p>You can view all of your job's candidates by clicking on the job's title from the Job Postings page. From here, you can scroll through candidates, view their applications and notify them if you're interested.</p>
        <p>You can press the &#x1F44D; or &#x1F44E; buttons on each candidate to let them know if you're interested or if you don't think they're a good fit.</p>
        <p>Please note, once an action is selected applicants will be notified through a no-reply email. Candidates will not have your contact info, so no further action needs to be taken for &#x1F44E;, but please be sure to contact the applicants directly after pressing &#x1F44D; to coordinate next steps.</p>
        <p>If you want to increase the awareness of your job and become a featured job on our board, you can also <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/job-postings"><strong>Upgrade</strong></a> your job at any time on your Job Postings page.</p>
        <p>If you have any questions for <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> and SBS team, feel free to reach out anytime at <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a>.</p>
        <p>Regards,<br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent