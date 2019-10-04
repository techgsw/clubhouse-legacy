@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($inquiry_user->first_name) }} {{ ucwords($inquiry_user->last_name) }} just applied for the <strong>{{ $job->title }}</strong> position with the <strong>{{ $job->organization->name }}</strong></p>
        <p><a href="{{ env('CLUBHOUSE_URL') }}/job/{{ $job->id }}">Click here</a> to view their application.</p>
        <h2>What's next?</h2>
        <p>From the Job page (see the link above) you can scroll through candidates, view their applications and notify them if you're interested. You can press the &#x1F44D; or &#x1F44E; buttons on each candidate to let them know if you're interested or if you don't think they're a good fit. Please note, applicants will be notified through a no-reply email so candidates will not have your contact info. Please be sure to contact them directly after pressing &#x1F44D; or &#x1F44E; to coordinate next steps.</p>
    @endslot
@endcomponent
