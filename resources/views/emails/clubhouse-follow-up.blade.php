@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }} - Thanks for signing up to be a <strong>Clubhouse “Pro”</strong>.</p>
        <p>My name is Bob Hamer and I’m the President & Founder of Sports Business Solutions and Creator of <span style="color: #EB2935;">the</span>Clubhouse platform. It means a lot to have you as part of our community.</p>
        <p>As a first step, it’d be great to set up a call. I’d love to learn more about you and your goals for the platform to ensure we meet and exceed those. Let me know if you’re up to it, and if so, when you’re free? Thanks!</p>
        <p>-Bob</p>
    @endslot
@endcomponent
