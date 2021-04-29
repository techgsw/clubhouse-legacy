@component('emails.layout')
    @slot ('title')
        Talk with sports industry mentors
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>On of the biggest benefits of Clubhouse PRO membership is access to the mentor network.</p>
        <p>We’ve assembled the biggest list of sports industry mentors around (140+ and counting) and they’re only accessible to PRO members like you.</p>
        <p>Through <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> you can schedule 30-minute calls with any mentor. Use these calls to network, learn, build relationships, and gain insights from people who’ve done it at the highest levels in sports.</p>
        <p>You may schedule two mentorship calls per week, so long as you retain your status as an active PRO member.</p>
        <p><i>My advice?</i> Make it a goal to schedule at least one call per week. Start with people you’re most interested in talking with and expand from there. There is absolutely no downside here and if you aren’t actively networking in sports, you’re missing out!</p>
        <p>Happy networking and let us know if you have any questions.</p>
        <div class="row" style="display:flex;justify-content:center;">
            <a class="email-sbs-red-button" href="{{ env('CLUBHOUSE_URL') }}/mentor" style="margin-bottom:20px">
                <strong>Set up mentorship calls now</strong>
            </a>
        </div>
        @include('emails.signature-footer')
    @endslot
@endcomponent

