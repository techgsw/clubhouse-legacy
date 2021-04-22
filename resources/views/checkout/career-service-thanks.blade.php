@extends('layouts.clubhouse')
@section('title', 'Success in Sports')
@section('scripts')
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script> 
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card checkout-card">
                <div class="card-content">
                    <h5>{{ Auth::user()->first_name }},</h5>
                    @can('view-clubhouse')
                        <p>Thank you for signing up for our <strong>{{ $product_option->product->name }}</strong> career service!</p>
                    @else
                        <p>Thank you for purchasing our <strong>{{ $product_option->product->name }}</strong> career service! A receipt has been emailed to you with all your purchase details.</p>
                    @endcan
                    @if($transaction->scheduled_flag)
                        <p>You have already scheduled this appointment. A second email should have been sent to you with info about the appointment. If you have not received this email or have not yet scheduled an appointment please contact <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a> for assistance.</p>
                    @else
                        <p>A representative from <strong><span class="sbs-red-text">the</span>Clubhouse</strong> will be in touch soon with more information about the service and to schedule a meeting time with you.</p>
                        <p>If for some reason you don’t hear from us within the next two business days, please email us directly at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions.</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
