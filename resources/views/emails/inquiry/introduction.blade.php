@component('emails.layout')
    @slot('body')
        <p>{{ucwords($user->first_name)}},</p>
        <p>Congratulations on posting your first job on <strong><span style="color: #EB2935;">the</span>Clubhouse</strong>!</p>
        <h2>What's next?</h2>
        <p>You can view or edit your posting at any time on your <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/job-postings">Job Postings</a> page. You can also use this page to see if anyone has <strong>Applied</strong> to your job, or if a member of <span style="color: #EB2935;">the</span>Clubhouse team has <strong>Assigned</strong> a candidate to your job.</p>
        <p>You can view all of your job's candidates by clicking on the job's title from the Job Postings page. From here, you can scroll through candidates, view their applications and notify them if you're interested. You can press the &#x1F44D; or &#x1F44E; buttons on each candidate to let them know if you're interested or if you don't think they're a good fit. Please note, applicants will be notified through a no-reply email so candidates will not have your contact info. Please be sure to contact directly after pressing &#x1F44D; or &#x1F44E; to coordinate next steps.</p>
        <p>If you want to increase the awareness of your job and become a featured job on our board, you can also <strong>Upgrade</strong> your job at any time on your Job Postings page.</p>
        <p>If you have any questions for <span style="color: #EB2935;">the</span>Clubhouse and SBS team, feel free to reach out anytime at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>.</p>
        <p>Regards,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent