<header>
    @include('layouts.components.auth-nav')
    <nav class="nav-main" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="/" class="brand-logo">
                <img src="/images/logo.png" alt="Sports Business Solutions">
            </a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/about">About</a></li>
                <li><a href="{{env('CLUBHOUSE_URL')}}">Clubhouse</a></li>
                <li><a href="/question">Q&A Forum</a></li>
            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li class="social-media">
                    <a href="https://facebook.com/sportsbusinesssolutions"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/SportsBizBob"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://instagram.com/sportsbizsol"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/in/bob-hamer-b1ab703"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                </li>
                <li><a href="/contact" class="sbs-red white-text">Contact</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="{{env('CLUBHOUSE_URL')}}">Clubhouse</a></li>
                <li><a href="/question">Q&A Forum</a></li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
        </div>
    </nav>
    @yield('subnav')
    @include('layouts.components.breadcrumb')
</header>
