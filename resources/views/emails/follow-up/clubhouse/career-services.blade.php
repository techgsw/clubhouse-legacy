@component('emails.layout')
    @slot ('title')
        Want 1 on 1 career advice?
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Do you have questions about sports industry careers? Are you a job seeker? Are you an industry PRO looking to get to the next level? Or to a new team? Are you preparing for an interview? Need help with your business plan? Have you ever wanted 1:1 career advice from someone other than your boss and/or colleagues?</p>
        <p>We can be that resource for you!</p>
        <p><strong>As a Clubhouse PRO member, you now get access to 1:1 <a href="{{ env('CLUBHOUSE_URL') }}/career-services">career services</a>.</strong> These sessions are facilitated by Bob Hamer, President and Founder of SBS and <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>.</p>
        <div class="row" style="display:flex;justify-content:center;">
            <a class="email-sbs-red-button" href="{{ env('CLUBHOUSE_URL') }}/career-services" style="margin-bottom:20px">
                <strong>Schedule a career service</strong>
            </a>
        </div>
        @include('emails.signature-footer')
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent

