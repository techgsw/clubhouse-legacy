@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <h5>{{ Auth::user()->first_name }},</h5>
            <p>Thank you for signing up to attend our <strong>{{ $product_option->product->name }}</strong> webinar on <strong>{{ $product_option->name }}</strong> at <strong>{{ $product_option->description }}</strong>! We’re glad you’ll be joining us for the discussion and hope you find it to be valuable.</p>
            <p>As a next step, you can prepare some questions you’d like to ask our guest(s), there will be 15 minutes of Q/A at the end of the presentation.</p>
            <p>Remember to schedule the time in your calendar now so you have a reminder to attend.</p>
            <p>You should receive the webinar login information approximately 48 hours before the call. If you haven’t received it by then, or have any additional questions please email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a>.</p>
            <p>If you are registering for a webinar within 48 hours of the event, you’ll be sent the call information approximately 2 hours prior to the call.</p>
            <p><span class="sbs-red-text">*</span>If you register for a webinar less than 2 hours prior to the call we’ll do our best to get you the call information before it starts, however, we’ll be preparing to run the meeting, so we cannot guarantee you’ll gain access to the live event.</p>
            <p>If you do miss the live call, all registered attendees will be emailed the recording of the session after the call takes place and can download it at any time on the Clubhouse Webinar home page.</p>
            <p>See you there!</p>
        </div>
    </div>
</div>
@endsection
