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
            <div class="card-flex-container" style="margin-top:20px;">
                <div class="card large" style="height:100%;margin-bottom: 20px;">
                    <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                        <h5 class="center-align" style="font-weight: 600;">Become a Clubhouse PRO Member</h5>
                    </div>
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="row">
                            <div class="col s12">
                                <h4 class="center-align" style="margin-bottom: 35px;"><strong>You're taking your skills to the next level!<br>Connect with industry pros, watch webinars, and get sales training  <span class="sbs-red-text" style="white-space: nowrap;">FREE for {{CLUBHOUSE_FREE_TRIAL_DAYS}} days</span>.</strong></h4>
                            </div>
                            <div class="col s12 m6">
                                <h5 class="center-align" style="margin-bottom: 35px;"><strong>Everything you are getting in <span class="sbs-red-text">the</span>Clubhouse community:</strong></h5>
                                <div style="margin-left: 30px; margin-right: 30px;">
                                    <ul class="fa-check-override">
                                        <li>Attend sports industry webinars</li>
                                        <li>Access the sports job board</li>
                                        <li>Get best practices by reading our blog</li>
                                        <li>Maintain your mental health with #SameHere Solutions</li>
                                        <li>Stay up to date with <span class="sbs-red-text">the</span>Clubhouse newsletter</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div style="margin-left: 30px; margin-right: 30px;">
                                    <h5 class="center-align" style="margin-bottom: 35px;"><strong>Plus these <span class="sbs-red-text">PRO</span> member services:</strong></h5>
                                    <ul class="fa-check-override">
                                        <li>Sports Career Services including:</li>
                                        <ul class="fa-check-override">
                                            <li>1:1 interview prep and resume coaching</li>
                                            <li>LinkedIn&#8482; profile and personal branding review</li>
                                            <li>Phone consultation to help you navigate tough industry challenges</li>
                                            <li>Career Q&A and action plan</li>
                                        </ul>
                                        <li>Get 1:1 career mentorship with sports industry pros</li>
                                        <li>Access our on-demand Webinar library, with more than 50 hours of content</li>
                                        <li>Enter the Sales Vault – Sales training videos for the sport salesperson</li>
                                        <li>Attend live premium webinars and events</li>
                                        <li>Receive a free 30-minute career consultation with Bob Hamer, President & Founder of SBS Consulting and Creator of <span class="sbs-red-text">the</span>Clubhouse</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="registration-form" method="post" action="/pro-membership">
            {{ csrf_field() }}
            <div class="row center-align">
                <h4>Tell us a little more about yourself or update your profile.</h4>
            </div>
            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="title" type="text" name="title" value="{{$user->contact->title}}">
                    <label for="title">Job Title (if employed)</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="organization" type="text" name="organization" value="{{$user->contact->organization}}">
                    <label for="organization">Organization (if employed)</label>
                </div>
            </div>
            <div class="row" style="margin-bottom: 30px;">
                <span class="years-worked-warning sbs-red-text hidden">Please select an option</span>
                <div class="input-field col s12">
                    <strong>How many years have you worked in sports? </strong><span class="sbs-red-text">*</span>
                    <input type="checkbox" id="years-worked-0" name="years-worked-0" class="years-worked" {{$user->profile->works_in_sports_years_range == '0' ? 'checked' : ''}}/>
                    <label for="years-worked-0" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>0 years (not started yet)</span></label>
                    <input type="checkbox" id="years-worked-1-2" name="years-worked-1-2" class="years-worked" {{$user->profile->works_in_sports_years_range == '1-2' ? 'checked' : ''}}/>
                    <label for="years-worked-1-2" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>1-2 years</span></label>
                    <input type="checkbox" id="years-worked-3-5" name="years-worked-3-5" class="years-worked" {{$user->profile->works_in_sports_years_range == '3-5' ? 'checked' : ''}}/>
                    <label for="years-worked-3-5" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>3-5 years</span></label>
                    <input type="checkbox" id="years-worked-6-9" name="years-worked-6-9" class="years-worked" {{$user->profile->works_in_sports_years_range == '6-9' ? 'checked' : ''}}/>
                    <label for="years-worked-6-9" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>6-9 years</span></label>
                    <input type="checkbox" id="years-worked-10" name="years-worked-10" class="years-worked" {{$user->profile->works_in_sports_years_range == '10' ? 'checked' : ''}}/>
                    <label for="years-worked-10" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>10+ years</span></label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span class="planned-services-warning sbs-red-text hidden">Please select at least one option</span>
                </div>
                <div class="col s12">
                    <strong>Which features and career services do you plan to use? <span class="sbs-red-text">*</span></strong>
                </div>
                <div class="input-field col m6 s12" style="max-width: 250px;">
                    <input type="checkbox" id="services-webinar" name="services-webinar" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('webinar', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-webinar" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Webinars</span></label>
                    <br>
                    <input type="checkbox" id="services-mentorship" name="services-mentorship" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('mentorship', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-mentorship" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Industry Mentorship</span></label>
                    <br>
                    <input type="checkbox" id="services-job-board" name="services-job-board" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('job-board', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-job-board" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Job Board</span></label>
                    <br>
                    <input type="checkbox" id="services-sales-training" name="services-sales-training" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('sales-training', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-sales-training" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Sales Training</span></label>
                    <br>
                    <input type="checkbox" id="services-mental-health" name="services-mental-health" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('mental-health', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-mental-health" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Mental Health</span></label>
                </div>
                <div class="input-field col m6 s12">
                    <input type="checkbox" id="services-interview-coaching" name="services-interview-coaching" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('interview-coaching', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-interview-coaching" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Interview and Resume Coaching</span></label>
                    <br>
                    <input type="checkbox" id="services-linkedin-brand" name="services-linkedin-brand" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('linkedin-brand', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-linkedin-brand" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>LinkedIn&#8482; Brand Review</span></label>
                    <br>
                    <input type="checkbox" id="services-phone-consultation" name="services-phone-consultation" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('phone-consultation', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-phone-consultation" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Phone Consultation</span></label>
                    <br>
                    <input type="checkbox" id="services-action-plan" name="services-action-plan" class="planned-services" {{!is_null($user->profile->planned_services) && in_array('action-plan', $user->profile->planned_services) ? 'checked' : ''}}>
                    <label for="services-action-plan" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Career Action Plan</span></label>
                </div>
            </div>
            <div class="row">
                <span style="margin-top:20px;"><span class="sbs-red-text">*</span> : Required</span>
            </div>
            <div class="row" style="margin-top:20px;">
                <div class="card-flex-container">
                    <div class="card large">
                        <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                            <div class="col s12" style="padding: 10px 0 50px 0;">
                                <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">Monthly</span></strong></h5>
                                <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                                <p class="center-align" style="font-size: 20px"><strong>{{money_format('%.2n', $monthly_membership_option->price)}}/month</strong></p>
                                <div style="margin-left: 30px; margin-right: 30px; padding-top: 20px;">
                                    <p style="font-size: 16px; min-height: 80px;">Become a Clubhouse Pro today! The first {{CLUBHOUSE_FREE_TRIAL_DAYS}} days are free and then it's just {{ money_format('%.2n', $monthly_membership_option->price) }} a month after that. You will be billed monthly {{CLUBHOUSE_FREE_TRIAL_DAYS}} days after signing up.</p>
                                </div>
                            </div>
                            <div class="col s12 center-align" style="padding-bottom: 10px;">
                                <button type="submit" name="buy_monthly" value="{{$monthly_membership_option->getURL(false, 'checkout')}}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro Monthly</button>
                            </div>
                        </div>
                    </div>
                    <div class="card large">
                        <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                            <div class="col s12" style="padding: 10px 0 50px 0;">
                                <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">Annually</span></strong></h5>
                                <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                                <p class="center-align" style="font-size: 20px"><strong>{{ money_format('%.2n', $annual_membership_option->price) }}/year</strong></p>
                                <div style="margin-left: 30px; margin-right: 30px; padding-top: 20px;">
                                    <p style="font-size: 16px; min-height: 80px;"><i>Looking to save some money!?</i> You can pay for your entire membership up front and get an <strong>extra month for free</strong>. You will be billed annually {{CLUBHOUSE_FREE_TRIAL_DAYS}} days after signing up.</p>
                                </div>
                            </div>
                            <div class="col s12 center-align" style="padding-bottom: 10px;">
                                <button type="submit" name="buy_monthly" value="{{$annual_membership_option->getURL(false, 'checkout')}}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Pro Annually</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
