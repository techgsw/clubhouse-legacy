@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry->user->first_name) }} {{ ucwords($inquiry->user->last_name) }},</p>
        <p>Thanks again for applying for the {{ $inquiry->job->title }} job with the {{ $inquiry->job->organization_name }}.</p>
        <p>We want to make sure we keep you updated on your status as a candidate for this position. With that said, we’re excited to let you know that <b>you are</b> advancing to the next stage in the process. Your application is being sent along to the appropriate hiring manager for review.</p>
        <p>While this doesn’t guarantee an official interview, it’s a step in the right direction! Someone from the SBS team or the {{ $inquiry->job->organization }} should be in touch with you in the weeks ahead. If anything changes regarding your status as a candidate we’ll continue to update you via email.</p>
        <p>Best of luck through this process!</p>
        <p>The Sports Business Solutions team</p>
    @endslot
@endcomponent
