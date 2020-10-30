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
        <p>You can respond to this email directly or at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>.</p>
        <p>Thanks, <br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
