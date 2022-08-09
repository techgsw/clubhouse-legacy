<header>
    @include('layouts.components.clubhouse.auth-nav')
    @if (Auth::user() && (! Auth::user()->profile->isComplete() && ! Auth::user()->profile->dontAskToComplete()))
        @include('layouts.components.clubhouse.complete-profile-banner')
    @endif
    <nav class="nav-main" role="navigation">
        <div class="nav-wrapper container">
            <!--<a href="/" style="color: #3F3E3E; left: 0; margin-top: 25px;" class="brand-logo">CLUBHOUSE</a>-->
            <div class="row" >
                <a href="/" class="brand-logo left-align custom-brand-logo">
                    <img src="/images/logos/full/CH_logo_color.jpg?v=1" alt="SBS Consulting" style="margin-bottom: 2.0rem;">
                </a>
            </div>
            <div class="row" style=" margin-top: 3rem;">
                <ul class="hide-on-med-and-down nav-custom-desktop" style="position: relative; z-index: 999;">
                    <li><a href="/our-team">Our Team</a></li>
                    <li><a href="/job">Job Board</a></li>
                    <li><a href="/mentor">Mentorship</a></li>
                    <li><a href="/pro-membership">PRO Membership</a></li>
                    <li><a href="/training">Training Vault</a></li>
                    <li><a href="/webinars">Webinars</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/same-here">Mental Health</a></li>
                </ul>
            </div>
            <ul id="nav-mobile-clubhouse" class="side-nav">
                <li class="social-media">
                    <a href="https://www.facebook.com/TheClubhouse-458907761265631" style="max-width: 20px"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/theC1ubhouse"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://instagram.com/theC1ubhouse"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/company/the-clubhouse-gsw"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                </li>
                <li><a href="https://generalsportsworldwide.com" style="text-transform: none; font-size: 18px;">General Sports Worldwide</a></li>
                <li class="divider"></li>
                <li><a href="/our-team">Our Team</a></li>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/mentor">Mentorship</a></li>
                <li><a href="/pro-membership">PRO Membership</a></li>
                <li><a href="/training">Training Vault</a></li>
                <li><a href="/webinars">Webinars</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/same-here">Mental Health</a></li>
                <li class="divider"></li>
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a class="modal-trigger" href="#register-modal">Register</a></li>
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
            <a href="#" data-activates="nav-mobile-clubhouse" class="button-collapse button-collapse-custom"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
        </div>
    </nav>
    @yield('subnav')
    @include('layouts.components.breadcrumb')
</header>
