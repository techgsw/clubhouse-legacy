@extends('layouts.blank')
<div class="container">
    <div class="row" style="margin-top: 5%;">
        <div class="col s12 center-align">
            <img class="responsive-img" alt="theClubhouse®" src="{{ env('APP_URL') }}/images/CH_logo_color.jpg?v=1" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 0;">
        <div class="col s12 center-align">
            <h4 style="font-weight: 700; color: #424242;">The <i>new</i> destination for everything you need to succeed in sports business.<br /><br />Mentorship, Industry Best Practices, Career Growth & More.</h4>
            <h5 class="sbs-red-text" style="margin-bottom: 0;"><strong>Launching Fall 2018.</strong></h5>
            <p style="margin-top: 5px; font-weight: 400; color: #424242;">Brought to you by the team at <a style="color: #9C9C9C;" href="https://sportsbusiness.solutions">SBS Consulting</a></p>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 offset-m3 center-align">
            <!-- Begin MailChimp Signup Form -->
            <form action="//solutions.us9.list-manage.com/subscribe/post?u=56eef2fd830c9e861e4987eec&amp;id=73202cc53b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <div id="mc_embed_signup_scroll">
                    <div class="input-field">
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                        <label for="email">Email</label>
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_56eef2fd830c9e861e4987eec_a8d932ef2d" tabindex="-1" value=""></div>
                    <input class="btn sbs-red" type="submit" value="Join Our Community" name="subscribe" id="mc-embedded-subscribe">
                </div>
            </form>
            <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
            <!--End mc_embed_signup-->
        </div>
    </div>
</div>
