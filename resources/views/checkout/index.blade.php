@extends('layouts.clubhouse')
@section('title', 'Checkout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h5><strong>{{ Auth::user()->first_name }},</strong></h5>
            <p><strong>Thank you for your interest in our product. Just a few more steps and you are all set.</strong></p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6">
            <select class="" name="payment-method">
                <option value="" "selected" disabled>Please select...</option>
            </select>
            <label for="payment-method">Payment method</label>
        </div>
        <div class="input-field col s12 m6">
            <button id="add-cc-button" type="button" class="btn btn-medium sbs-red">Add card</button>
        </div>
    </div>
    <div class="cc-form scale-transition scale-out hidden">
        @include('forms.add-card')
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-panel grey lighten-5 z-depth-1">
                <div class="row valign-wrapper">
                    <div class="col s2">
                        <img src="images/home/training.jpg" alt="" class="responsive-img"> <!-- notice the "circle" class -->
                    </div>
                    <div class="col s8">
                        <span class="black-text">Clubhouse membership. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed urna quis ex euismod faucibus. Ut dignissim risus at semper fringilla. Maecenas vel tincidunt eros. Cras vitae fringilla leo, non luctus risus.</span>
                    </div>
                    <div class="col s2">
                        <h4><strong>$60.00*</strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @php
                $date = new DateTime('NOW');
            @endphp
            <p style="color: #EB2935;">*Your membership will be billed monthly begging on the {{ $date->format('jS') }} of this month.</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <button id="checkout-submit-button" type="submit" class="btn btn-medium green darken-1">Pay Now</button>
        </div>
    </div>
</div>
@endsection
