<header>
    @include('layouts.components.clubhouse.auth-nav')
    <nav class="nav-main" role="navigation">
        <div class="nav-wrapper container">
            <a href="/" style="color: #3F3E3E; left: 0; margin-top: 25px;" class="brand-logo">CLUBHOUSE</a>
            <!--
            <a id="" href="/" class="brand-logo left-align">
                <img src="/images/logo.png" alt="Sports Business Solutions">
            </a>
            -->
            <ul class="right hide-on-med-and-down">
                <li><a href="/blog">Blog</a></li>
                <li><a href="/mentor">Mentorship</a></li>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/product?tag=webinar">Webinars</a></li>
                <li><a href="/services" class="dropdown-button" data-activates="services-dropdown" data-hover="true" data-beloworigin="true" data-constrainwidth="false">Services</a></li>
                <!-- Dropdown Structure -->
                <ul id="services-dropdown" class="dropdown-content">
                    <li><a href="/training-consulting">Training &amp; Consulting</a></li>
                    <li><a href="/recruiting">Recruiting</a></li>
                    <li><a href="/career-services">Career Services</a></li>
                </ul>
                <li><a href="#">Resources</a></li>
            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li class="social-media">
                    <a href="https://facebook.com/sportsbusinesssolutions"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/SportsBizBob"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://instagram.com/sportsbizsol"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/in/bob-hamer-b1ab703"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                </li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/mentor">Mentorship</a></li>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/product?tag=webinar">Webinars</a></li>
                <li><a href="/training-consulting">&mdash;Training &amp; Consulting</a></li>
                <li><a href="/recruiting">&mdash;Recruiting</a></li>
                <li><a href="/career-services">&mdash;Career Services</a></li>
                <li><a href="#">Resources</a></li>
                <li class="divider"></li>
                <li><a href="/contact" class="sbs-red white-text">Contact</a></li>
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    @if (Auth::user()->hasAccess('admin_index'))
                        <li><a href="/admin">Admin</a></li>
                        <li class="divider"></li>
                    @endif
                    <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
        </div>
    </nav>
    @yield('subnav')
    @include('layouts.components.breadcrumb')
</header>
