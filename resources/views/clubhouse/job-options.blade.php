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
            <div class="card-flex-container" style="justify-content:center;">
                <div class="card medium" style="min-width:300px;max-width:425px;">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="grey-text text-darken-1">FREE</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <br />
                            <p class="center-align" style="font-size: 18px; font-weight: 400;">Add your job to the job board now!</p>
                            <br />
                            <p class="center-align" style="font-size: 16px; font-weight: 400;">Try this option out for free. There’s no risk and there’s a chance you find your future hire! Why wait?! Post your job today.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if (Auth::guest())
                                <a href="#register-modal" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @else
                                <a href="job/create" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card medium" style="min-width:300px;max-width:425px;">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 30px 0;">
                            <h5 class="center-align sbs-red-text" style="font-size: 24px"><strong>PREMIUM</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <br />
                            <!--<p class="center-align" style="font-size: 18px; font-weight: 400;">Boost your job posting now!</p>-->
                            <p class="center-align" style="font-size: 18px; font-weight: 400;">Increase the awareness of your job!</p>
                            <br />
                            <p class="center-align" style="font-size: 16px; font-weight: 400;">Become a featured job on the job board and receive additional exposure. You’ll also be assigned quality candidates from the SBS database based on your search criteria.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <p class="center-align" style="font-size: 15px; font-weight: 400;">Email <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a> to get a pricing quote.</p>
                            @if ($job_premium)
                                <a href="mailto:clubhouse@sportsbusiness.solutions" class="buy-now btn sbs-red" style="margin-top: 18px;">Contact Us</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card medium" style="min-width:300px;max-width:425px;">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 30px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong>PLATINUM</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <br />
                            <p class="center-align" style="font-size: 18px; font-weight: 400;">Maximize your exposure and we do the work!</p>
                            <br />
                            <p class="center-align" style="font-size: 16px; font-weight: 400;">Platinum jobs get the most social media and email promotion. We assign you candidates AND we screen them for you, ensuring that by the time they get to you, they’re qualified and interested.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <p class="center-align" style="font-size: 15px; font-weight: 400;">Email <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a> to get a pricing quote.</p>
                            @if ($job_platinum)
                                <a href="mailto:clubhouse@sportsbusiness.solutions" class="buy-now btn sbs-red" style="margin-top: 18px;">Contact Us</a>
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
                @include('components.job-options-comparison-table')
                <table class="highlight">
                    <tbody>
                        <tr>
                            <td style="width: 300px; padding-right: 20px;"></td>
                            <td class="center">
                                @if (Auth::guest())
                                    <a href="#register-modal" class="btn sbs-red" style=""> Get started</a>
                                @else
                                    <a href="job/create" class="btn sbs-red" style=""> Get started</a>
                                @endif
                            </td>
                            <td class="center">
                                @if ($job_premium)
                                    <a href="mailto:clubhouse@sportsbusiness.solutions" class="buy-now btn sbs-red" style="">Contact Us</a>
                                @endif
                            </td>
                            <td class="center">
                                @if ($job_platinum)
                                    <a href="mailto:clubhouse@sportsbusiness.solutions" class="buy-now btn sbs-red" style="">Contact Us</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
