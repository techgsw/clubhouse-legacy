<header>
    <nav class="nav-user hide-on-med-and-down" role="navigation">
        <div class="nav-wrapper container">
            @can ('view-admin-dashboard')
                <ul>
                    <li><a href="/admin">ADMIN</a></li>
                </ul>
            @endif
            <ul class="right">
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
                <li><a class="sbs-red white-text" href="/contact">Contact</a></li>
            </ul>
        </div>
    </nav>
    <nav class="nav-main" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="/" class="brand-logo">
                <img src="/images/logo.png" alt="Sports Business Solutions">
            </a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/about">About</a></li>
                <li><a href="/services" class="dropdown-button" data-activates="services-dropdown" data-hover="true" data-beloworigin="true" data-constrainwidth="false">Services</a></li>
                <!-- Dropdown Structure -->
                <ul id="services-dropdown" class="dropdown-content">
                    <li><a href="/training-consulting">Training &amp; Consulting</a></li>
                    <li><a href="/recruiting-3">Recruiting</a></li>
                    <li><a href="/career-services">Career Services</a></li>
                </ul>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/the-hub">The Hub</a></li>
            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li><a href="/about">About</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/job">Job Board</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/blog">Blog</a></li>
                <li class="divider"></li>
                <li><a href="/the-hub">The Hub</a></li>
                <li><a href="/question">Q&amp;A Forum</a></li>
                <li><a href="/training-consulting">Training</a></li>
                <li><a href="/#clients">Clients</a></li>
                <li class="divider"></li>
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
