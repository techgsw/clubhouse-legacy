@component('emails.layout')
    @slot ('title')
        Your one-month update
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>You’ve now been part of our community for one month, thanks for supporting us!</p>
        <p>We get that you’re busy, so if you haven’t had time to check out our content in <span style="color: #EB2935;">the</span>Clubhouse, that’s ok!</p>
        <p>Here’s a friendly reminder of what you get access to as a FREE member of <span style="color: #EB2935;">the</span>Clubhouse:</p>
        <ul>
            <li>Our <a href="{{ env('CLUBHOUSE_URL') }}/blog">blog</a>, with career success stories and industry best practices</li>
            <li>Sales training tips and tricks in the <a href="{{ env('CLUBHOUSE_URL') }}/sales-vault">sales vault</a></li>
            <li>Attend our sports industry webinars, see <a href="{{ env('CLUBHOUSE_URL') }}/webinars">upcoming events</a></li>
            <li>Apply for new <a href="{{ env('CLUBHOUSE_URL') }}/job">jobs in sports</a></li>
            <li>Better manage your mental health in sports through <a href="{{ env('CLUBHOUSE_URL') }}/same-here">#SameHere Solutions</a></li>
        </ul>
        <p>We’d love your feedback. What’s been your favorite part of the experience thus far?</p>
        <p>Want 1:1 career advice and mentorship? Become a <a href="{{ env('CLUBHOUSE_URL') }}/pro-membership">Clubhouse PRO</a>.</p>
        <p>See you back in <span style="color: #EB2935;">the</span>Clubhouse soon!</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent

