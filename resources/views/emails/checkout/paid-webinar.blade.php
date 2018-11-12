@component('emails.layout')
    @slot ('title')
        Webinar RSVP - theClubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for signing up for our upcoming webinar {{ $product_option->product->name }} on {{ $product_option->name }} {{ $product_option->description }}.</p>
        <p>Don’t forget to add the event to your calendar, and we look forward to having you join us! <strong>The live webinar login instructions will be sent via email to this address 24 hours prior to the call.</strong> If you have RSVP’d within 24 hours of the live event, you’ll be sent the login instructions 1 hour prior to the call. Any RSVPs within 2 hours of the webinar cannot be guaranteed access to the live event.</p>
        <p>We know life happens, so if you miss the session (or sign up too late), you can always find the webinar recording on our webinars page after the event.</p>
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
