@component('emails.layout')
    @slot('body')
        <p>Hey {{$mentor->contact->first_name}},</p>
        <p>Thanks for being a mentor. Over the last {{$days_since}} days you've had calls scheduled with these individuals:</p>
        <ul>
        @foreach ($mentor->mentorRequests as $mentor_request)
            <li><b>{{$mentor_request->mentee->first_name}} {{$mentor_request->mentee->last_name}}</b> (Requested on {{$mentor_request->created_at->format('m/d/Y')}})</li>
        @endforeach
        </ul>
        <p>It'd be great to have your feedback. How did they go? Did they all show up? Were there any difficulties getting scheduled? Is there anything we can do to make this experience better for you?</p>
        <p>If any of these are scheduled for the future, feel free to let us know how they went after they happen.</p>
        <p>If you get a request outside of theClubhouse® site from someone who says they "saw you were a mentor in theClubhouse®" please direct them back to your Clubhouse profile link to schedule the call vs. scheduling it on your own. That way we can keep track of them all.</p>
        <p>You can respond to this email directly or at <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a>.</p>
        <p>Thanks, <br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent
