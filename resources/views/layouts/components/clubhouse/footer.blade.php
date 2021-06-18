<footer class="page-footer">
    <div class="container">
        <div class="row" style="margin-bottom:0px;">
            <div class="col m5 s12">
                <a href="#register-modal" class="no-underline"><img style="max-height:285px;max-width:100%;" src="/images/CH_Footer_Ads-Member.jpg"></a>
            </div>
            <div class="col m4 s12">
                @include('layouts.components.instagram')
            </div>
            <div class="col m3 s12">
                @include('layouts.components.clubhouse.twitter')
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="footer-nav">
                    <li><a target="_blank" href="/documents/SBS-Consulting-Terms-of-Service.pdf">Terms and conditions</a></li>
                    <li>Have a question? Email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <p class="small">Copyright &copy; {{ date('Y') }} SBS Consulting | All Rights Reserved</p>
        </div>
    </div>
    @include('layouts.components.message-template')
</footer>
