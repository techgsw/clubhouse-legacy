@component('emails.layout')
    @slot ('title')
        Welcome to PRO membership!
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Welcome to Clubhouse PRO membership! We applaud you for taking this step towards achieving even greater success in sports.</p>
        <p>Over the course of the next few weeks, we’ll be giving you information on how to maximize your new PRO membership.</p>
        <p>First, we’d like to schedule a call with you to get to know you better. These calls will be facilitated by <strong>Josh Belkoff</strong>, who’s a Vice President on our team at SBS and <span style="color: #EB2935;">the</span>Clubhouse. Schedule your call with Josh <a href="https://calendly.com/jbelkoff/clubhouse-intro">here</a>.</p>
        <p>If you haven’t done so already, please update your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">career profile</a> so we have all of your accurate information prior to the call.</p>
        <p>We look forward to working with you!</p>
        <div class="row" style="display:flex;justify-content:center;">
            <a class="email-sbs-red-button" href="https://calendly.com/jbelkoff/clubhouse-intro" style="margin-bottom:20px">
                <strong>Schedule your intro call now</strong>
            </a>
        </div>
        @include('emails.signature-footer')
    @endslot
@endcomponent
