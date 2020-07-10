<footer class="page-footer">
    <div class="container">
        <div class="row" style="margin-bottom:0px;">
            <div class="col m5 s12">
                <img style="max-height:285px;max-width:100%;" src="/images/CH_Footer_Ad-Career_Services.jpg">
            </div>
            <div class="col m4 s12">
                @include('layouts.components.instagram')
            </div>
            <div class="col m3 s12">
                @include('layouts.components.twitter')
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="footer-nav">
                    <li><a href="/refund-policy-2">Refund policy</a></li>
                    <li><a href="/privacy-policy">Privacy policy</a></li>
                    <li><a href="/terms-of-service">Terms and conditions</a></li>
                    <li><a href="tel:6023501223">(602)-350-1223</a></li>
                    <li><a href="mailto:support@sportsbusiness.solutions">support@sportsbusiness.solutions</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <p class="small">Copyright &copy; {{ date('Y') }} Sports Business Solutions | All Rights Reserved</p>
        </div>
    </div>
    @include('layouts.components.message-template')
</footer>
