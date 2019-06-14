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
            @if ($product_type == 'career-service')
                <p><strong>Thank you for your interest in our {{ $product_option->name }}. Just a few more steps and you are all set.</strong></p>
            @elseif ($product_type == 'webinar')
                <p><strong>Thank you for your interest in {{ $product_option->product->name }}. Just a few more steps and you are all set.</strong></p>
            @elseif ($product_type == 'job-plus')
                <p><strong>Are you ready to find the industry professional you've been looking for? Just a few more steps and you are all set.</strong></p>
            @else
                <p><strong>Thank you for choosing to become a Clubhouse Pro. Just a few more steps and you'll be ready to begin your <span class="sbs-red-text">30 day Free Trial</span>.</strong></p>
            @endif
        </div>
    </div>
    <div class="cc-form scale-transition scale-out hidden">
        @include('forms.add-card')
    </div>
    <form method="post" id="checkout-form" action="/checkout">
        {{ csrf_field() }}
        <input type="hidden" name="stripe_product_id" value="{{ ($product_option->stripe_plan_id ? $product_option->stripe_plan_id : $product_option->stripe_sku_id) }}" /> 
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
            <div class="input-field col s12 m6 {{ $product_type == 'webinar' ? 'hidden' : '' }}" id="payment-method-wrapper">
                <select class="" name="payment_method" id="payment-method">
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
            <div class="input-field col s12 m6 {{ $product_type == 'webinar' ? 'hidden' : '' }}">
                <button id="add-cc-button" type="button" class="btn btn-medium sbs-red">Add card</button>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card-panel grey lighten-5 z-depth-1 product-card" data-product-type="{{ $product_type }}">
                    <div class="row hide-on-med-and-up">
                        <div class="col s12 center-align">
                            @if (!is_null($product_option->product->primaryImage()))
                                <img style="width: 120px; margin: 0 auto;" class="responsive-img" src="{{ $product_option->product->primaryImage()->getURL('medium') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="row hide-on-med-and-up">
                        <div class="col s12">
                            @if ($product_type == 'webinar')
                                <p class="black-text"><strong>{{ $product_option->product->name }}</strong></p>
                                <p class="black-text">{{ $product_option->name }} ({{ $product_option->description }})</p>
                                <p class="black-text">{{ $product_option->product->getCleanDescription() }}</p>
                            @else
                                <p class="black-text"><strong>{{ $product_option->product->name }}</strong></p>
                                <p class="black-text">{{ $product_option->product->getCleanDescription() }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row hide-on-med-and-up center-align">
                        <div class="col s12">
                            @if ($product_option->price > 0)
                                @can ('view-clubhouse')
                                    <h4><strong>{{ money_format('%.2n', round($product_option->price / 2)) }}</strong></h4>
                                @else
                                    <h4><strong>{{ money_format('%.2n', $product_option->price) }}</strong><span>{{ ($product_type == 'membership' ? ($product_option->price == 7.0 ? ' / Month' : '/ Year') : '') }}</span></h4>
                                @endcan
                            @else
                                <h4><strong>{{ money_format('%.2n', $product_option->price) }}</strong></h4>
                            @endif
                        </div>
                    </div>
                    <div class="row valign-wrapper hide-on-small-only">
                        <div class="col s2">
                            @if (!is_null($product_option->product->primaryImage()))
                                <img style="width: 120px; margin: 0 auto;" class="responsive-img" src={{ $product_option->product->primaryImage()->getURL('medium') }} />
                            @endif
                        </div>
                        <div class="col s8">
                            @if ($product_type == 'webinar')
                                <p class="black-text"><strong>{{ $product_option->product->name }}</strong></p>
                                <p class="black-text">{{ $product_option->name }} ({{ $product_option->description }})</p>
                                <p class="black-text">{{ $product_option->product->getCleanDescription() }}</p>
                            @else
                                <p class="black-text"><strong>{{ $product_option->product->name }}</strong></p>
                                <p class="black-text">{{ $product_option->product->getCleanDescription() }}</p>
                            @endif
                        </div>
                        <div class="col s2">
                            @if ($product_option->price > 0)
                                @can ('view-clubhouse')
                                    <h4><strong>{{ money_format('%.2n', round($product_option->price / 2)) }}</strong></h4>
                                @else
                                    <h4><strong>{{ money_format('%.2n', $product_option->price) }}</strong><span>{{ ($product_type == 'membership' ? ($product_option->price == 7.0 ? ' / Month' : '/ Year') : '') }}</span></h4>
                                @endcan
                            @else
                                <h4><strong>{{ money_format('%.2n', $product_option->price) }}</strong></h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                @if ($product_type == 'membership')
                    <p style="color: #EB2935; margin-bottom: 20px;">*Your membership will be billed {{ $product_option->price == 7.0 ? 'monthly' : 'annually' }} beginning one month after date of checkout.</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 center-align" style="margin-bottom: 50px;">
                @if ($product_type == 'webinar')
                    <button id="checkout-submit-button" type="submit" class="btn btn-medium green darken-1">RSVP Now</button>
                @elseif ($product_type == 'membership')
                    <button id="checkout-submit-button" type="submit" class="btn btn-medium green darken-1">Begin Now</button>
                @else
                    <button id="checkout-submit-button" type="submit" class="btn btn-medium green darken-1">Pay Now</button>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
