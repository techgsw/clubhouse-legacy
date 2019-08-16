@component('emails.layout')
    @slot('body')
        <p>Hi {{$contact_job->contact->first_name}}</p>
        <p>As a member of <span style="color: #EB2935;">the</span>Clubhouse you have been identified as a potential match for an opportunity with the <strong>{{ $contact_job->job->organization_name }}</strong>.  They are currently seeking a new <strong>{{ $contact_job->job->title }}</strong> and the hiring manager would like to arrange a conversation to discuss the opportunity further.</p>
        <p>Would you like to move forward in the interview process? If so, let us know and someone will be in touch with you shortly to coordinate next steps.</p>
        <p>
            <a href="{{ env('CLUBHOUSE_URL') }}/user-assigned/feedback/{{ $contact_job->id }}?interest=interested&token={{ $contact_job->job_interest_token }}">Yes, I am interested.</a>
            <br />
            <a href="{{ env('CLUBHOUSE_URL') }}/user-assigned/feedback/{{ $contact_job->id }}?interest=not-interested&token={{ $contact_job->job_interest_token }}">No, I am not interested.</a>
        </p>
        <p>Thank you for being a part of our community and we wish you all the best as you take your next steps in your career!</p>
        <p>Sincerely,</p>
        <p>The SBS and Clubhouse Team</p>
    @endslot
@endcomponent
