@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry_user->first_name) }} {{ ucwords($inquiry_user->last_name) }} just applied for the <strong>{{ $job->title }}</strong> position with the <strong>{{ $job->organization->name }}</strong></p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/job/{{ $job->id }}">Click here</a> to view their application.</p>
        <h2>What's next?</h2>
        <p>From the Job page (see the link above) you can scroll through candidates, view their applications and notify them if you're interested.</p>
        <p>You can press the &#x1F44D; or &#x1F44E; buttons on each candidate to let them know if you're interested or if you don't think they're a good fit.</p>
        <p>Please note, once an action is selected applicants will be notified through a no-reply email. Candidates will not have your contact info, so no further action needs to be taken for &#x1F44E;, but please be sure to contact the applicants directly after pressing &#x1F44D; to coordinate next steps.</p>
    @endslot
@endcomponent
