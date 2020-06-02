<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col m4 s12">
                @include('layouts.components.newsletter')
            </div>
            <div class="col m4 s12">
                @include('layouts.components.instagram')
            </div>
            <div class="col m4 s12">
                @include('layouts.components.clubhouse.twitter')
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="footer-nav">
                    <li><a target="_blank" href="/documents/Sports-Business-Solutions-Terms-of-Service.pdf">Terms and conditions</a></li>
                    <li>Have a question? Email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></li>
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
