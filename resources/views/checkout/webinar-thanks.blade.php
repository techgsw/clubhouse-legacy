@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card checkout-card">
                <div class="card-content">
                    <h5>{{ Auth::user()->first_name }},</h5>
                    <p>Thank you for signing up to attend our <strong>{{ $product_option->product->name }}</strong>  webinar on <strong>{{ $product_option->name }}</strong> at <strong>{{ $product_option->description }}</strong>! We’re glad you will be joining us for the discussion and hope you find it to be valuable.</p>
                    <p>You will get an email to your Clubhouse email address with all the call-in information. Within that email you can also add the call to your calendar, be sure to do that so you don’t forget about us! Please email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a> if you don’t get the invitation.</p>
                    <p>Be sure to prepare some questions for our guest speaker(s). We’ll have 10-15 minutes of Q&A at the end of the discussion.</p>
                    <p>Thanks for being a part of <span class="sbs-red-text">the</span>Clubhouse community. See you on the call!</p>
                    <p>-<span class="sbs-red-text">the</span>Clubhouse team</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
