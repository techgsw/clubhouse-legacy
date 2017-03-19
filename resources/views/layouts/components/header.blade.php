<header>
    <nav class="nav-user" role="navigation">
        <div class="nav-wrapper container">
            <ul class="right hide-on-med-and-down">
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
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
                <li><a href="/services">Services</a></li>
                <li><a href="/jobs">Job Board</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/sales-center">Sports Sales Center</a></li>
                <!-- Dropdown?
                <li><a class='dropdown-button' href='#' data-activates='services-dropdown' data-hover="true" data-constrainwidth="false" data-beloworigin="true">Sports Sales Center</a></li>
                <ul id='services-dropdown' class='dropdown-content'>
                    <li><a href="/school">School</a></li>
                    <li><a href="/blog">Sports Sales Blog</a></li>
                    <li><a href="/question">Q&amp;A</a></li>
                    <li><a href="/training">Training videos</a></li>
                    <li><a href="/clients" >Clients</a></li>
                </ul>
                -->
            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li><a href="/about">About</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/jobs">Job Board</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/blog">Blog</a></li>
                <li class="divider"></li>
                <li><a href="#">Sports Sales Center</a></li>
                <li><a href="/question">Q&amp;A</a></li>
                <li><a href="/job">Job Board</a></li>
                <li class="divider"></li>
                <li><a href="/help">Help</a></li>
                <li class="divider"></li>
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <nav class="nav-sub nav-center" role="navigation">
        <div class="nav-wrapper container">
            <ul class="hide-on-med-and-down">
                <li><a href="/school">School</a></li>
                <li><a href="/blog">Sports Sales Blog</a></li>
                <li><a href="/question">Q&amp;A</a></li>
                <li><a href="/training">Training videos</a></li>
                <li><a href="/clients" >Clients</a></li>
            </ul>
        </div>
    </nav>
    @include('layouts.components.breadcrumb')
</header>
