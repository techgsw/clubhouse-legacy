@component('emails.layout')
    @slot ('title')
        Career Service Purchase - theClubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for purchasing one of our Clubhouse Career Services! We’ve got you signed up for the following session:</p>
        <p>{{ $product_option->product->name }} - {{ money_format('%2n', $product_option->price) }}</p>
        <p>Here’s what happens next:</p>
        <ul>
            <li>Within three business days, a member of our Clubhouse team will reach out directly via email to find a date and time for your session.</li>
        </ul>
        <p>As you start to get to know your personal coach, it’s great to share additional thoughts on what you’d like to focus on and/or achieve during your 1:1 session(s). The more we know, the better we can help you!</p>
        <p>We’re looking forward to helping you achieve your goals in sports business. Talk soon!</p>
        <p>Thanks,<br/>theClubhouse Team</p>
    @endslot
@endcomponent
