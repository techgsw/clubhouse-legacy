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
    <div class="cc-form scale-transition scale-out hidden">
        @include('forms.add-card')
    </div>
    <div class="row">
        <div class="col s12 m6 hidden" id="card-waiting">
            <div class="row valign-wrapper">
                <div class="col s2">
                    <img src="/images/progress.gif" class="responsive-img circle" />
                </div>
                <div class="col s10">
                    <h4>Adding card, please wait.</h4>
                </div>
            </div>
        </div>
        <div class="input-field col s12 m6" id="payment-method-wrapper">
            <select class="" name="payment-method" id="payment-method">
                @if (count($payment_methods) > 0)
                    @foreach ($payment_methods as $index => $method)
                        <option value="{{ $method->id }}" {{ $index == 0 ? "selected" : "" }} >XXX-XXX-XXX-{{ $method->last4 }}</option>
                    @endforeach
                @else
                    <option value="" "selected" disabled>Please select...</option>
                @endif
            </select>
            <label for="payment-method">Payment method</label>
        </div>
        <div class="input-field col s12 m6">
            <button id="add-cc-button" type="button" class="btn btn-medium sbs-red">Add card</button>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-panel grey lighten-5 z-depth-1">
                <div class="row hide-on-med-and-up">
                    <div class="col s12 center-align">
                        <img style="width: 120px; margin: 0 auto;" class="responsive-img" src={{ $product_option->product->primaryImage()->getURL('medium') }} />
                    </div>
                </div>
                <div class="row hide-on-med-and-up">
                    <div class="col s12">
                        <p class="black-text">{{ $product_option->product->name }}</p>
                        <p class="black-text">{{ $product_option->name }}</p>
                        <p class="black-text">{{ $product_option->description }}</p>
                    </div>
                </div>
                <div class="row hide-on-med-and-up center-align">
                    <div class="col s12">
                        <h4><strong>{{ money_format('%.2n', $product_option->price) }}</strong></h4>
                    </div>
                </div>
                <div class="row valign-wrapper hide-on-small-only">
                    <div class="col s2">
                        <img style="width: 120px; margin: 0 auto;" class="responsive-img" src={{ $product_option->product->primaryImage()->getURL('medium') }} />
                    </div>
                    <div class="col s8">
                        <p class="black-text">{{ $product_option->product->name }}</p>
                        <p class="black-text">{{ $product_option->name }}</p>
                        <p class="black-text">{{ $product_option->description }}</p>
                    </div>
                    <div class="col s2">
                        <h4><strong>{{ money_format('%.2n', $product_option->price) }}</strong></h4>
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
