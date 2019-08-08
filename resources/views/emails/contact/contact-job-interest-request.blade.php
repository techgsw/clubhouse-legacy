@component('emails.layout')
    @slot('body')
        <p>Hi {{$contact_job->contact->first_name}}</p>
        <p>As a member of the Sports Business Solutions network, you have been identified as a potential match for one of our partners job openings.  The {{ $contact_job->job->organization_name }} are currently seeking a new {{ $contact_job->job->title }}, and the hiring manager would like to arrange a conversation to discuss the opportunity further.</p>
        <p>Would like to move forward in the interview process? If so, let us know and someone will be in touch with you shortly to coordinate next steps.</p>
        <p>
            <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=interested&token={{ $contact_job->job_interest_token }}">Yes, I am interested.</a>
            <br />
            <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=not_interested&token={{ $contact_job->job_interest_token }}">No, I am not interested.</a>
        </p>
        <p>We wish you all the best as you take your next steps in your career!</p>
        <p>Sincerely,</p>
        <p>The SBS and Clubhouse Team</p>
        <br />
        <p style="font-size: 10px; color: grey;">Don't want to hear from us again? Let us know by <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=dnc&token={{ $contact_job->job_interest_token }}">clicking here</a></p>
    @endslot
@endcomponent
