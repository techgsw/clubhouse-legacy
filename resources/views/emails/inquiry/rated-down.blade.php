@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }} {{ ucwords($inquiry->user->last_name) }},</p>
        <p>Thanks again for applying for the {{ $inquiry->job->title }} job with the {{ $inquiry->job->organization_name }}.</p>
        <p>We want to make sure we keep you updated on your status as a candidate for this position. With that said, unfortunately you <b>will not</b> be advancing to the next stage in the process. We’re sorry but there were other candidates who seem to be a better fit for the position at this time.</p>
        <p>Although this is the end of the road on this one, we encourage you to follow along with our job board for other career opportunities in sports. We’d be happy to consider you for another position in the future.</p>
        <p>Best of luck and hope to talk again soon!</p>
        <p>The Sports Business Solutions team</p>
    @endslot
@endcomponent
