@component('emails.layout')
    @slot ('title')
        Sports industry best practices
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>In <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> we host 1-2 educational webinars per month, sometimes more. These sessions are moderated by our team, but often include industry guest speakers who share advice and sports industry best practices.</p>
        <p>These are the same speakers that are asked to speak at industry conferences all over the country. To access those conferences, you must be part of those leagues or pay to travel and gain access to those events.</p>
        <p>With your new PRO membership, you can access all the live sessions, AND watch the entire library (70+ events) of past shows from your home or phone, on demand. The content is just as good as what you’d see live, and you can get it for a lot less money.</p>
        <p>You can find everything <a href="{{ env('CLUBHOUSE_URL') }}/webinars">here</a>. <i>My recommendation?</i> Once a week, pick out a subject that’s of interest to you, watch the show, jot down some notes, and then reach out to the speakers. Easy way to learn and make new contacts.</p>
        <div class="row" style="display:flex;justify-content:center;">
            <a class="email-sbs-red-button" href="{{ env('CLUBHOUSE_URL') }}/webinars" style="margin-bottom:20px">
                <strong>Watch Webinars Now</strong>
            </a>
        </div>
        @include('emails.signature-footer')
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent

