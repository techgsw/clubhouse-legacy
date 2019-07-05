@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card checkout-card">
                <div class="card-content">
                    <h5>{{ Auth::user()->first_name }},</h5>
                    <p>Thank you for purchasing our <strong>{{ $product_option->product->name }}</strong> option! A receipt has been emailed to you with all your purchase details.</p>
                    <p>A representative from <strong><span class="sbs-red-text">the</span>Clubhouse</strong> will be in touch soon with more information about the service and to schedule a meeting time with you.</p>
                    <p>If for some reason you don’t hear from us within the next two business days, please email us directly at <a href="clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions.</a></p>
                    <div class="center-align" style="margin-top: 20px;">
                        <a class="btn sbs-red" href="/job/create">Create your job</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
