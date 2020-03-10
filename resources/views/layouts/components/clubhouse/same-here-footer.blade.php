<footer class="page-footer">
    <div class="container-fluid" style="padding:40px 0px;">
        <div class="row center-align">
            <h4><strong>Let's get social! Follow our organizations below.</strong></h4>
        </div>
        <div class="row">
            <div class="col m3 offset-m1 s12">
                <div class="row center-align same-here-social">
                    <h5><a href="{{ env('APP_URL') }}">Sports Business Solutions</a></h5>
                    <br>
                    <a class="flat-button" href="https://instagram.com/sportsbizsol"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    &nbsp;
                    &nbsp;
                    <a class="flat-button" href="https://facebook.com/sportsbusinesssolutions"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    &nbsp;
                    &nbsp;
                    <a class="flat-button" href="https://twitter.com/SportsBizSol"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col m3 s12"  style="border-right: 1px solid #888;">
                <div class="row center-align same-here-social">
                    <h5><a href="https://weareallalittlecrazy.org/">We're All A Little "Crazy"</a></h5>
                    <br>
                    <a class="flat-button" href="https://instagram.com/samehere_global"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    &nbsp;
                    &nbsp;
                    <a class="flat-button" href="https://facebook.com/weareallalittlecrazy"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    &nbsp;
                    &nbsp;
                    <a class="flat-button" href="https://twitter.com/samehere_global"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col m4 s12">
                <div class="hide-on-med-and-up center-align">
                    <h5><strong>Want to talk to someone 1 on 1?<br>Email us directly at</strong><br><a href="mailto:samehere@sportsbusiness.solutions">samehere@sportsbusiness.solutions</a></h5>
                </div>
                <div class="hide-on-small-and-down" style="padding:20px 50px;">
                    <h5><strong>Want to talk to someone 1 on 1?<br>Email us directly at</strong><br><a href="mailto:samehere@sportsbusiness.solutions">samehere@sportsbusiness.solutions</a></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="same-here-feed">
        @include('layouts.components.same-here-instagram')
    </div>
    <div class="footer-copyright">
        <div class="container">
            <p class="small">Copyright &copy; 2018 Sports Business Solutions | All Rights Reserved</p>
        </div>
    </div>
    @include('layouts.components.message-template')
</footer>
