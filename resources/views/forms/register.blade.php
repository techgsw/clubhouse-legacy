<form class="registration-form" method="post" action="{{ route('register') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12">
            <p>Already a member? <a href="/login">Login!</a></p>
        </div>
    </div>
    <div class="row" style="margin:30px 0px;">
        <span class="membership-type-warning sbs-red-text hidden">Please select a membership type</span>
        <div class="card-flex-container">
            <div class="input-field card large">
                <div class="card-content">
                    <div class="col s12" style="padding: 10px 0 50px 0;">
                        <input type="checkbox" id="membership-selection-free" name="membership-selection-free" class="membership-selection"/>
                        <label for="membership-selection-free" class="sbs-red-checkbox"><h7 style="font-size: 24px; color:#000;"><strong>Join <span class="sbs-red-text">the</span>Clubhouse Community!<br><span class="sbs-red-text">FREE</span></strong></h7></label>
                        <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                            <ul class="fa-check-override">
                                <li>LIVE Sports Sales & Service webinars</li>
                                <li>Sports Industry Job Board</li>
                                <li>Sports Industry Blog</li>
                                <li><span class="sbs-red-text">the</span>Clubhouse Newsletter</li>
                                <li>#SameHere Solutions for mental well-being</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-field card large">
                <div class="card-content">
                    <div class="col s12" style="padding: 10px 0 50px 0;">
                        <input type="checkbox" id="membership-selection-pro" name="membership-selection-pro" class="membership-selection"/>
                        <label for="membership-selection-pro" class="sbs-red-checkbox"><h7 style="font-size: 24px;color:#000;"><strong>Become a Clubhouse PRO Member!<br><span class="sbs-red-text">{{CLUBHOUSE_FREE_TRIAL_DAYS}}-DAY FREE TRIAL</span></strong></h7></label>
                        <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                            <ul class="fa-check-override">
                                <li>Everything listed in the Free membership</li>
                                <li>Exclusive 1:1 career mentorship from over 100+ sports industry professionals</li>
                                <li>On-demand Sports Industry webinar library with 50+ hours of talking with team executives and industry professionals</li>
                                <li>Sales Training Vault of how-to videos</li>
                                <li>30-minute career consultation with Sports Business Solutions President Bob Hamer</li>
                                <li>Career Services including:</li>
                                    <ul class="fa-check-override">
                                        <li>1:1 interview and resume coaching</li>
                                        <li>LinkedIn&#8482; profile review</li>
                                        <li>Phone consultation with hiring managers</li>
                                        <li>Career Q&A and action plan</li>
                                    </ul>
                                <li>Access to additional on-demand premium content</li>
                            </ul>
                        </div>
                        <span class="pro-payment-type-warning sbs-red-text hidden">Please select a payment type</span>
                        <div class="input-field">
                            <strong style="font-size:20px;">Choose one:</strong><br>
                            <input type="checkbox" id="membership-selection-pro-monthly" name="membership-selection-pro-monthly" class="membership-selection"/>
                            <label for="membership-selection-pro-monthly" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span class="sbs-red-text">$7/MONTH</span></label>
                            <input type="checkbox" id="membership-selection-pro-annually" name="membership-selection-pro-annually" class="membership-selection"/>
                            <label for="membership-selection-pro-annually" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span class="sbs-red-text">$77/YEAR - 1 MONTH FREE</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('first_name') ? 'invalid' : '' }}">
            <input id="first-name" type="text" name="first_name" value="{{ old('first_name') }}" required>
            <label for="first-name">First name</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('last_name') ? 'invalid' : '' }}">
            <input id="last-name" type="text" name="last_name" value="{{ old('last_name') }}" required>
            <label for="last-name">Last name</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select id="title" name="title" required>
                <option value="" disabled selected>Choose your current title</option>
                <option value="C-Level or Owner">C-Level or Owner</option>
                <option value="VP">VP</option>
                <option value="Director">Director</option>
                <option value="Manager">Manager</option>
                <option value="Account Executive">Account Executive</option>
                <option value="Entry Level">Entry Level</option>
                <option value="Student">Student</option>
                <option value="Other">Other</option>
            </select>
            <label for="title">Title</label>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px;">
        <span class="years-worked-warning sbs-red-text hidden">Please select an option</span>
        <div class="input-field col s12">
            <strong>How many years have you worked in sports?</strong>
            <input type="checkbox" id="years-worked-0" name="years-worked-0" class="years-worked" />
            <label for="years-worked-0" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>0 years (not started yet)</span></label>
            <input type="checkbox" id="years-worked-1-2" name="years-worked-1-2" class="years-worked" />
            <label for="years-worked-1-2" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>1-2 years</span></label>
            <input type="checkbox" id="years-worked-3-5" name="years-worked-3-5" class="years-worked" />
            <label for="years-worked-3-5" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>3-5 years</span></label>
            <input type="checkbox" id="years-worked-6-9" name="years-worked-6-9" class="years-worked" />
            <label for="years-worked-6-9" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>6-9 years</span></label>
            <input type="checkbox" id="years-worked-10" name="years-worked-10" class="years-worked" />
            <label for="years-worked-10" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>10+ years</span></label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <span class="planned-services-warning sbs-red-text hidden">Please select at least one option</span>
        </div>
        <div class="col s12 m6">
            <strong>Which features do you plan to use?</strong>
        </div>
        <div class="col hide-on-small-and-down m6">
            <strong>Which career services do you plan to use?</strong>
        </div>
        <div class="input-field col m6 s12">
            <input type="checkbox" id="services-webinar" name="services-webinar" class="planned-services">
            <label for="services-webinar" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Webinars</span></label>
            <br>
            <input type="checkbox" id="services-mentoring" name="services-mentoring" class="planned-services">
            <label for="services-mentoring" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Mentoring</spanw></label>
            <br>
            <input type="checkbox" id="services-job-board" name="services-job-board" class="planned-services">
            <label for="services-job-board" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Job Board</span></label>
            <br>
            <input type="checkbox" id="services-sales-training" name="services-sales-training" class="planned-services">
            <label for="services-sales-training" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Sales Training</span></label>
            <br>
            <input type="checkbox" id="services-mental-health" name="services-mental-health" class="planned-services">
            <label for="services-mental-health" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Mental Health</span></label>
        </div>
        <div class="col s12 hide-on-med-and-up">
            <strong>Which career services do you plan to use?</strong>
        </div>
        <div class="input-field col m6 s12">
            <input type="checkbox" id="services-interview-coaching" name="services-interview-coaching" class="planned-services">
            <label for="services-interview-coaching" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Interview and Resume Coaching</span></label>
            <br>
            <input type="checkbox" id="services-linkedin-brand" name="services-linkedin-brand" class="planned-services">
            <label for="services-linkedin-brand" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>LinkedIn&#8482; Brand Review</span></label>
            <br>
            <input type="checkbox" id="services-phone-consultation" name="services-phone-consultation" class="planned-services">
            <label for="services-phone-consultation" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Phone Consultation</span></label>
            <br>
            <input type="checkbox" id="services-action-plan" name="services-action-plan" class="planned-services">
            <label for="services-action-plan" class="sbs-red-checkbox" style="top:0;margin:0px 10px;"><span>Career Action Plan</span></label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('email') ? 'invalid' : '' }}">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            <label for="email">Email Address</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('password') ? 'invalid' : '' }}">
            <input id="password" type="password" name="password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="password-confirm" type="password" name="password_confirmation" required>
            <label for="password-confirm">Confirm Password</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6" style="margin-bottom: 20px;">
            <div class="row">
                <input id="newsletter" name="newsletter" type="checkbox" checked>
                <label for="newsletter" class="sbs-red-checkbox">Receive <span class="sbs-red-text">the</span>Clubhouse newsletter</label>
            </div>
            <div class="row">
                <input id="terms" name="terms" type="checkbox" required>
                <label for="terms" class="sbs-red-checkbox">I agree to the <a target="_blank" rel="noopener" href="/documents/Sports-Business-Solutions-Terms-of-Service.pdf">terms of service</a>.</label>
            </div>
        </div>
        <div class="col s12 m6">
            <span class="recaptcha-warning sbs-red-text hidden">Please check the box below</span>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align">
            <button type="submit" class="btn sbs-red">Complete Registration</button>
        </div>
    </div>
</form>
