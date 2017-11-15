@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>We haven't seen you in a while so we wanted to reach out and let you know about what's happening at Sports Business Solutions.</p>
        <p>Over the last year, we have been hard at work building a platform that provides you with the tools you need to succeed in sports business.</p>
        <p>We started with our new <a href="{{ url('/') }}/login">User Profile</a>, which is designed to help us match you with jobs that align with your experience and goals in sports business. Next, we created the <a href="{{ url('/') }}/job">Job Board</a> that, when coupled with our new profile, simplifies the application process to a single click. Looking for more? Check out our <a href="{{ url('/') }}/question">Q&A Forum</a> for tips, insights and advice from professionals in the industry.</p>
        <p><a href="{{ url('/') }}/password/reset?migration=true&name={{ ucwords($user->first_name) }}">Click here to get started!</a></p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
