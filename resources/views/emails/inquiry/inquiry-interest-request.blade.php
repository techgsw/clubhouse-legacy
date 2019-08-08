@component('emails.layout')
    @slot('body')
        <p>Hi {{$inquiry->user->first_name}}</p>
        <p>Thank you for visiting <span class="sbs-red-text">the</span>Clubhouse job board and for being a member of our community!</p>
        <p>You are receiving this message as a confirmation of your application for the {{ $inquiry->job->title }} position with the {{ $inquiry->job->organization_name }}. After reviewing your resume, you have been identified as a potential fit for this opportunity and the hiring manager would like to move forward with the interview process.</p>
        <p>Would like to move forward in the interview process? If so, let us know and someone will be in touch with you shortly to coordinate next steps.</p>
        <p>
            <a href="{{ env('CLUBHOUSE_URL') }}/user/feedback/{{ $inquiry->id }}?interest=interested&token={{ $inquiry->job_interest_token }}">Yes, I am interested.</a>
            <br />
            <a href="{{ env('CLUBHOUSE_URL') }}/user/feedback/{{ $inquiry->id }}?interest=not_interested&token={{ $inquiry->job_interest_token }}">No, I am not interested.</a>
        </p>
        <p>Thank you for being a part of our community and we wish you the best as you take your next steps in your career!</p>
        <p>Sincerely,</p>
        <p>The SBS and Clubhouse Team</p>
        <br />
        <p style="font-size: 10px; color: grey;">Don't want to hear from us again? Let us know by <a href="{{ env('CLUBHOUSE_URL') }}/user/feedback/{{ $inquiry->id }}?interest=dnc&token={{ $inquiry->job_interest_token }}">clicking here</a></p>
    @endslot
@endcomponent
