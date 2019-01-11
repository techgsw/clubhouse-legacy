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
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">$7/month</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Become a Clubhouse Pro today! First 30 days are free, $7 a month after that. Billed monthly, first payment 30 days after initial purchase.</p>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($product)
                                @if (Auth::guest())
                                    <a href="/" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro at $7/month</a>
                                @else
                                    <a href="{{ $product->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro at $7/month</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">$70/year</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Looking to save some money!? Pay for your entire membership after your 30 day free trial and get an extra month for free! Billed annually, first payment 30 days after initial purchase.</p>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($product)
                                @if (Auth::guest())
                                    <a href="/" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro at $70/year</a>
                                @else
                                    <a href="{{ $product->options()->get()[1]->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro at $70/year</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
