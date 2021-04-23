@component('emails.layout')
    @slot ('title')
        Welcome to PRO membership!
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Welcome to Clubhouse PRO membership! We applaud you for taking this step towards achieving even greater success in sports.</p>
        <p>Over the course of the next few weeks, we’ll be giving you information on how to maximize your new PRO membership.</p>
        <p>If you haven’t done so already, please update your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">career profile</a> so we have all of your accurate information prior to the call.</p>
        <p>We look forward to working with you!</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent
