@component('emails.layout')
    @slot ('title')
        Welcome to theClubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for becoming a <strong>Clubhouse Pro</strong>! Your subscription is now active and you can begin enjoying your {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial. After that, you will be billed monthly via the card you provided.</p>
        <p>Here are a few key benefits to your <strong>"Pro"</strong> membership:</p>
        <ul>
            <li><strong>Mentorship</strong> - You are now able to set up calls with more than 95 sports industry professionals. Find a <a href="{{ env('CLUBHOUSE_URL') }}/mentor">mentor</a> now!</li>
            <li><strong>Career Services</strong> - We can help you work on your resume, build a career plan, or prepare for an interview! <a href="{{ env('CLUBHOUSE_URL') }}/career-services">Career Services</a> are free for <strong>Clubhouse Pro</strong> members, schedule one today.</li>
            <li><strong>Webinars</strong> - We have more than 50 hours of educational content in our webinar library. You can access it all <a href="{{ env('CLUBHOUSE_URL') }}/webinars">here</a>.</li>
            <li><strong>Sales Vault</strong> - Interested in getting some sales training? You now have access to all of our sales training videos in the <a href="{{ env('CLUBHOUSE_URL') }}/sales-vault">Sales Vault</a>.</li>
        </ul>
        <p>You can manage your account and billing preferences within your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">Clubhouse profile</a> on our site. Should you have any questions, need assistance or have ideas to share, please feel free to contact us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>.</p>
        <p>Regards,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
