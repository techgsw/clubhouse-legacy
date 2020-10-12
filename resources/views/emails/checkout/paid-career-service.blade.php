@component('emails.layout')
    @slot ('title')
        Career Service {{ \Gate::allows('view-clubhouse') ? 'Signup' : 'Purchase'}} - theClubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for {{ \Gate::allows('view-clubhouse') ? 'signing up for' : 'purchasing'}} one of our Clubhouse Career Services! We’ve got you signed up for the following session:</p>
        <p><b>{{ $product_option->product->name }}</b></p>
        @if($product_option->getCalendlyLink())
            <p>If you have not already scheduled an appointment, please follow the link below to do so:</p>
            <p><a href="{{env('CLUBHOUSE_URL')}}/checkout/thanks?type=career-service&product_option_id={{$product_option->id}}&transaction_id={{$transaction_id}}">Schedule an appointment</a></p>
            <p>After you've scheduled, you will receive another email confirming your appointment time.</p>
        @else
            <p>Here’s what happens next:</p>
            <ul>
                <li>Within three business days, a member of our Clubhouse team will reach out directly via email to find a date and time for your session.</li>
            </ul>
            <p>As you start to get to know your personal coach, it’s great to share additional thoughts on what you’d like to focus on and/or achieve during your 1:1 session(s). The more we know, the better we can help you!</p>
        @endif
        <p>We’re looking forward to helping you achieve your goals in sports business. Talk soon!</p>
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
