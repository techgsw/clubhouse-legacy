@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }} - Thanks for signing up to be a <strong>Clubhouse “Pro”</strong>.</p>
        <p>My name is Bob Hamer and I’m the President & Founder of SBS Consulting and Creator of <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> platform. It means a lot to have you as part of our community.</p>
        <p>As a first step, it’d be great to <a href="https://calendly.com/bob-hamer/clubhouse-intro">set up a call</a>. I’d love to learn more about you and your goals for the platform to ensure we meet and exceed those. If you're open to a call, just click the link below and book a time on my calendar. Look forward to talking soon!</p>
        <p>-Bob</p>
        <div class="row" style="display:flex;justify-content:center;">
            <a class="btn btn-large sbs-red" href="https://calendly.com/bob-hamer/clubhouse-intro" style="margin-top:20px;margin-bottom:-20px">
                <strong>Schedule a call</strong>
            </a>
        </div>
    @endslot
@endcomponent
