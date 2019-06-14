@component('emails.layout')
    @slot ('title')
        Job Listing Purchase - theClubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thanks for purchasing our Job Listing Plus option! We are confident you will find the right applicant for your position.</p>
        <p>{{ $product_option->product->name }}</p>
        <p>Here’s what happens next:</p>
        <ul>
            <li>blah blah blah.</li>
        </ul>
        <p>More text.</p>
        <p>We’re looking forward to helping you find the right sports business professional. Talk soon!</p>
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
