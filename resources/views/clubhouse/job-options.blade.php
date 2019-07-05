@extends('layouts.clubhouse')
@section('title', 'Clubhouse Membership Options')
@section('hero')
    <div class="row hero bg-image membership-options">
        <div class="col s12">
            <h4 class="header">Job Posting Options</h4>
            <p>Where the industry goes for sports business professionals</p>
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
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="grey-text text-darken-1">Free</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 14px; font-weight: 400;">Do you want to get some additional views on your open job? Try this option out free of charge. There’s no risk and you may find your future hire! Why wait?! Let’s get started today.</p>
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
                            <h5 class="center-align sbs-red-text" style="font-size: 24px"><strong>FEATURED</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <p class="center-align" style="font-size: 14px; font-weight: 400;">Interested in getting more of the right candidates quicker?! You can supercharge your open job here. With this option your position will be added to our “featured job” section, where you will get additional views and engagement. You’ll also be sent 15 candidates from our database who are qualified for the role based on your search criteria.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_featured)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_featured->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Featured</a>
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
                            <p class="center-align" style="font-size: 14px; font-weight: 400;">Want us to do all the heavy lifting? No problem! Pick up this option and we’ll feature your job, promote it heavily via social media, assign candidates and screen them for you. This way, you’ll ensure that when you spend time talking to a candidate, not only are they qualified, but you know they’re interested in your job.</p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_platinum)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_platinum->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Platinum</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #F2F2F2;">
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
                            <th class="center sbs-red-text">Featured</th>
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
                            <td class="center"></i></td>
                            <td class="center"><i class="fa fa-check"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
