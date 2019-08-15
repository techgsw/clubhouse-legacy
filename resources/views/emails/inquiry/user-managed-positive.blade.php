@component('emails.layout')
    @slot('body')
        <p>Hi {{$inquiry->user->first_name}}</p>
        <p>Thank you for visiting <span style="color: #EB2935;">the</span>Clubhouse job board and for being a member of our community!</p>
        <p>You are receiving this message as a confirmation of your application for the {{ $inquiry->job->title }} position with the {{ $inquiry->job->organization_name }}. After reviewing your resume, you have been identified as a potential fit for this opportunity and the hiring manager would like to move forward with the interview process.</p>
        <p>Someone will be in touch with you shortly to coordinate next steps.</p>
        <p>Thank you for being a part of our community and we wish you the best as you take your next steps in your career!</p>
        <p>Sincerely,</p>
        <p>The SBS and Clubhouse Team</p>
        <br />
        <p style="font-size: 10px; color: grey;">Don't want to hear from us again? Let us know by <a href="{{ env('CLUBHOUSE_URL') }}/inquiry/feedback/{{ $inquiry->id }}?interest=dnc&token={{ $inquiry->job_interest_token }}">clicking here</a></p>
    @endslot
@endcomponent
