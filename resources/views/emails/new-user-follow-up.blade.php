@component('emails.layout')
    @slot('body')
        <p>Hello, {{ ucwords($user->first_name) }}!</p>
        <p>Welcome to the Sports Business Solutions family. We are excited to start, help, and grow your sports business career in the industry.</p>
        <p>As a thank you for joining our team, we would like to extend the opportunity to you to connect with our Sr. Director of Recruiting and Development, Josh Belkoff. He has been a hiring manager in the past and wants to help you gain the upper hand in your sports business ascension in the industry.</p>
        <p>Please reach out to him at <a href="mailto::josh@sportsbusiness.solutions">josh@sportsbusiness.solutions</a> to set up your conversation with Josh.</p>
        <p>Success in sports business starts here and we can’t wait to watch you grow in this special industry.</p>
        <p>Thank you,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
