@component('emails.layout')
    @slot ('title')
        Your Clubhouse Benefits
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thanks for being a part of <span style="color: #EB2935;">the</span>Clubhouse community. We hope you’re enjoying your experience with us so far.</p>
        <p>If you haven’t yet updated your career profile, you can do so <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">here</a>.</p>
        <p>As a FREE Clubhouse member, you can:</p>
        <ul>
            <li>RSVP to upcoming <a href="{{ env('CLUBHOUSE_URL') }}/webinars">Webinars</a></li>
            <li>Read more than 175 <a href="{{ env('CLUBHOUSE_URL') }}/blog">Blogs</a></li>
            <li>Watch sales training videos in the <a href="{{ env('CLUBHOUSE_URL') }}/sales-vault">Sales Vault</a></li>
            <li>Apply for sports jobs on the <a href="{{ env('CLUBHOUSE_URL') }}/job">Job Board</a></li>
            <li>Get tips on managing your mental health in sports through <a href="{{ env('CLUBHOUSE_URL') }}/same-here">#SameHere Solutions</a></li>
        </ul>
        <p>See you in <span style="color: #EB2935;">the</span>Clubhouse!</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent
