@component('emails.layout')
    @slot ('title')
        Webinar RSVP - theClubhouse®
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for signing up for our upcoming webinar {{ $product_option->product->name }} on {{ $product_option->name }} {{ $product_option->description }}.</p>
        <p>Don’t forget to add the event to your calendar, we look forward to you joining us! <strong>The live webinar login instructions will be sent to this address 48 hours prior to the call.</strong> If you RSVP’d within 48 hours of the event, you’ll be sent the login instructions approximately 2 hours prior to the call. Any RSVPs within 2 hours of the webinar cannot be guaranteed access to the live event.</p>
        <p>We know life happens, so if you miss the session (or sign up too late), you can always find the webinar recording on our webinars page after the event, and it will be emailed to you as well.</p>
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent
