@component('emails.layout')
    @slot('body')
        <p>Hi {{$inquiry->user->first_name}}</p>
        <p>Thank you for visiting <span style="color: #EB2935;">the</span>Clubhouse job board and for being a member of our community!</p>
        <p>You are receiving this message as a confirmation of your application for the <strong>{{ $inquiry->job->title }}</strong> position with the <strong>{{ $inquiry->job->organization_name }}</strong>. After reviewing your resume, you have been identified as a potential fit for this opportunity and the hiring manager would like to move forward with the interview process.</p>
        <p>Someone will be in touch with you shortly to coordinate next steps.</p>
        <p>Thank you for being a part of our community and we wish you the best as you take your next steps in your career!</p>
        <p>Sincerely,</p>
        <p>The SBS and Clubhouse Team</p>
    @endslot
@endcomponent
