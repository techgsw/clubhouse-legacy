@extends('layouts.clubhouse')
@section('title', 'Clubhouse Job Posting Options')
@section('hero')
    <div class="row hero bg-image membership-options">
        <div class="col s12">
            <h4 class="header">Job Posting Options</h4>
            <p>Where the industry goes for sports business professionals</p>
            <a href="#compare-options" class="btn sbs-red">Compare Options</a>
        </div>
    </div>
@endsection
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
                <div class="card medium">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="grey-text text-darken-1">FREE</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 24px; font-weight: bold;">$0.00</p>
                            <br />
                            <p class="center-align" style="font-size: 18px; font-weight: 400;">Add your job to the job board now!</p>
                            <br />
                            <p class="center-align" style="font-size: 16px; font-weight: 400;">Try this option out for free. There’s no risk and there’s a chance you find your future hire! Why wait?! Post your job today.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if (Auth::guest())
                                <a href="/register?type=employer" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @else
                                <a href="job/create" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card medium">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 0px 0;">
                            <h5 class="center-align sbs-red-text" style="font-size: 24px"><strong>PREMIUM</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 24px; font-weight: bold;">$500.00</p>
                            <br />
                            <!--<p class="center-align" style="font-size: 18px; font-weight: 400;">Boost your job posting now!</p>-->
                            <p class="center-align" style="font-size: 18px; font-weight: 400;">Increase the awareness of your job!</p>
                            <br />
                            <p class="center-align" style="font-size: 16px; font-weight: 400;">Become a featured job on the job board and receive additional exposure. You’ll also be assigned 15 quality candidates from the SBS database based on your search criteria.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_premium)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_premium->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Buy Now</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card medium">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong>PLATINUM</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 24px; font-weight: bold;">$1,500.00</p>
                            <br />
                            <p class="center-align" style="font-size: 18px; font-weight: 400;">Maximize your exposure and we do the work!</p>
                            <br />
                            <p class="center-align" style="font-size: 16px; font-weight: 400;">Platinum jobs get the most social media and email promotion. We assign you 15 candidates AND we screen them for you, ensuring that by the time they get to you, they’re qualified and interested.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_platinum)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_platinum->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Buy Now</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="compare-options" style="background-color: #F2F2F2;">
        <div class="container">
            <div class="row">
                <div class="col s12 center">
                    <h4 class="uppercase">COMPARE THE OPTIONS</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 center">
                <table class="highlight">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="center grey-text text-darkin-1">Free</th>
                            <th class="center sbs-red-text">Premium</th>
                            <th class="center">Platinum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Featured on the <span class="sbs-red-text">the</span>Clubhouse for 30 days</td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Included in our general job update newsletter</td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Job board will be promoted regularly through all social media channels</td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Featured on the <span class="sbs-red-text">the</span>Clubhouse for 45 days</td>
                            <td class="center"></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Your individual job will be emailed directly to candidates in our database</td>
                            <td class="center"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Custom social media graphic just for your job and promoted directly via all social media channels to maximize exposure</td>
                            <td class="center"></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">The Sports Business Solutions team will send you 15 additional job candidate matches based on your search criteria</td>
                            <td class="center"></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Featured on the <span class="sbs-red-text">the</span>Clubhouse for 60 days</td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">The Sports Business Solutions’ team of recruiters will screen and pre-qualify your candidate list to help identify the right person for the job</td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">The Sports Business Solutions’ team will send you a minimum of 5 candidates that are not only qualified, but pre-screened and interested in your position</td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;">Pricing</td>
                            <td class="center"><strong>$0.00</strong></td>
                            <td class="center"><strong>$500.00</strong></td>
                            <td class="center"><strong>$1,500.00</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;"></td>
                            <td class="center">
                                @if (Auth::guest())
                                    <a href="/register?type=employer" class="btn sbs-red" style=""> Get started</a>
                                @else
                                    <a href="job/create" class="btn sbs-red" style=""> Get started</a>
                                @endif
                            </td>
                            <td class="center">
                                @if ($job_premium)
                                    @if (Auth::guest())
                                        <a href="/register" class="buy-now btn sbs-red" style="">Register</a>
                                    @else
                                        <a href="{{ $job_premium->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="">Buy Now</a>
                                    @endif
                                @endif
                            </td>
                            <td class="center">
                                @if ($job_platinum)
                                    @if (Auth::guest())
                                        <a href="/register" class="buy-now btn sbs-red" style="">Register</a>
                                    @else
                                        <a href="{{ $job_platinum->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="">Buy Now</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
