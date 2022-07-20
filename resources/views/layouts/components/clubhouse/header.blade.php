<header>
    @include('layouts.components.clubhouse.auth-nav')
    <nav class="nav-main" role="navigation">
        <div class="nav-wrapper container">
            <!--<a href="/" style="color: #3F3E3E; left: 0; margin-top: 25px;" class="brand-logo">CLUBHOUSE</a>-->
            <a href="/" class="brand-logo left-align custom-brand-logo">
                <img src="/images/logos/full/CH_logo_color.jpg?v=1" alt="{{ __('general.company_name') }}">
            </a>
            <ul class="right hide-on-med-and-down nav-custom-desktop" style="margin-right: -50px;">
                <li><a href="/blog">Blog</a></li>
                <li><a href="/webinars">Webinars</a></li>
                <li><a href="/mentor">Mentors</a></li>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/training">Training</a></li>
                <li><a href="/same-here">Mental Health</a></li>
            </ul>
            <ul id="nav-mobile-clubhouse" class="side-nav">
                <li class="social-media">
                    <a href="https://www.facebook.com/TheClubhouse-458907761265631" style="max-width: 20px"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/theC1ubhouse"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://instagram.com/theC1ubhouse"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/company/the-clubhouse-sbs"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                </li>
                <li><a href="https://generalsportsworldwide.com" style="text-transform: none; font-size: 18px;">General Sports Worldwide</a></li>
                <li class="divider"></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/webinars">Webinars</a></li>
                <li><a href="/mentor">Mentors</a></li>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/training">Training</a></li>
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
