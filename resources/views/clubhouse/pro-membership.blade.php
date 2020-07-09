@extends('layouts.clubhouse')
@section('title', 'Clubhouse Membership Options')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                @include('layouts.components.messages')
                @include('layouts.components.errors')
            </div>
        </div>
        <div class="row">
            <div class="card-flex-container">
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">Monthly</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 20px"><strong>$7.00/month</strong></p>
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 20px;">
                                <p style="font-size: 16px; min-height: 80px;">Become a Clubhouse Pro today! The first {{CLUBHOUSE_FREE_TRIAL_DAYS}} days are free and then it's just $7.00 a month after that. You will be billed monthly {{CLUBHOUSE_FREE_TRIAL_DAYS}} days after signing up.</p>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($product)
                                @if (Auth::guest())
                                    <a href="#register-modal" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro at $7.00/month</a>
                                @else
                                    <a href="{{ $product->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro Monthly</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">Annually</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 20px"><strong>$77.00/year</strong></p>
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 20px;">
                                <p style="font-size: 16px; min-height: 80px;"><i>Looking to save some money!?</i> You can pay for your entire membership up front and get an <strong>extra month for free</strong>. You will be billed annually {{CLUBHOUSE_FREE_TRIAL_DAYS}} days after signing up.</p>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($product)
                                @if (Auth::guest())
                                    <a href="#register-modal" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro Annually</a>
                                @else
                                    <a href="{{ $product->options()->get()[1]->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro Annually</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
