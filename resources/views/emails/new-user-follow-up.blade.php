@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }}&mdash;</p>
        <p>Welcome to Sports Business Solutions! We are excited to help you succeed in this industry.</p>
        <p>As a thank you for joining our community, we’d like to offer you the opportunity to chat with our Sr. Director of Recruiting and Development, Josh Belkoff. He’s been a former hiring manager in sports and wants to learn more about your goals, and then offer advice to help you achieve them.</p>
        <p>This service is <b>free</b> and if you're interested, just email him at <a href="mailto::josh@sportsbusiness.solutions">josh@sportsbusiness.solutions</a>.</p>
        <p>Thanks, and we look forward to talking to you soon.</p>
        <p>The SBS Team</p>
    @endslot
@endcomponent
