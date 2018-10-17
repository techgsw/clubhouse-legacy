@component('emails.layout')
    @slot ('title')
        Welcome to theClubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for becoming a <strong>Clubhouse Pro</strong>! Your subscription is now active. We hope this investment in your career will pay big dividends for you in the future. You’re now able to start enjoying your 30-day free trial period. After that ends, you will be billed monthly via the card you provided.</p>
        <p>To get the most out of your <strong>Clubhouse Pro</strong> membership, here are a few tips:</p>
        <p>
            <ul>
                <li>Check our <a href="{{ config('app.url') }}/mentorship">mentorship page</a> often -  find the right mentor (or two!) and set up a 1:1 time with them to help you navigate through challenges or discuss topics related to your career in sports.</li>
                <li>Explore our <a href="{{ config('app.url') }}/career-services">career services</a> page - There are more than 15 personalized services to help you expand your skills (you’ll save 50% on each now that you’re a <strong>Clubhouse Pro</strong>)</li>
                <li>Keep an eye on our <a href="{{ config('app.url') }}/webinars">upcoming webinars</a> - find the topics and sessions that fit your interests in sports business. Miss one? That’s ok! Now you’ll have access to our library of past shows so you’ll never miss out.</li>
            </ul>
        </p>
        <p>You can manage your account and billing preferences within your <a href="{{ config('app.url') }}/user/{{ $user->id }}/profile">Clubhouse profile</a> on our site. Should you have any questions, need assistance or have ideas to share, please feel free to contact us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>.</p>
        <p>Regards,<br/>theClubhouse Team</p>
    @endslot
@endcomponent
