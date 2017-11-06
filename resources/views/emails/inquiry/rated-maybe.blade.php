@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }} {{ ucwords($inquiry->user->last_name) }},</p>
        <p>Thanks again for applying for the {{ $inquiry->job->title }} job with the {{ $inquiry->job->organization }}.</p>
        <p>We want to make sure we keep you updated on your status as a candidate for this position. With that said, because the applicant pool is so competitive for this job, we <b>have not yet determined</b> if you’re going to be advancing to the next round of the process.</p>
        <p>Although we can’t officially consider you a candidate yet, the good news is you’re still in the running! We expect to be back in touch with you soon with another status update via email. We appreciate your patience and just wanted to let you know that we haven’t forgotten about you.</p>
        <p>Best of luck in the weeks ahead and we look forward to talking again soon!</p>
        <p>The Sports Business Solutions team</p>
    @endslot
@endcomponent
