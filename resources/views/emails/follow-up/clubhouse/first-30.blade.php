@component('emails.layout')
    @slot ('title')
        Your first 30 days as a PRO
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>It’s hard to believe you’ve already been a Clubhouse PRO member for 30 days. Time flies when you’re having fun!</p>
        <p>As the President & Founder of <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>, having a great experience with us is especially important to me.</p>
        <p>I wanted to check in and see how this first month has gone for you?</p>
        <p>Look forward to hearing from you soon.</p>
        @include('emails.signature-footer')
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent

