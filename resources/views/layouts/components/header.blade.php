<header>
    <nav class="nav-main" role="navigation" style="height:85px;line-height:unset;">
        <div class="nav-wrapper container">
            <a id="logo-container" href="/" class="brand-logo">
                <img src="/images/sbs_consulting_logo.png" alt="SBS Consulting">
            </a>
            <ul class="right hide-on-med-and-down">
                <li><a class="{{ strpos(Request::url(), '/about') !== false ? 'current-page' : '' }}" href="/about">About</a></li>
                <li><a class="{{ strpos(Request::url(), '/training-consulting') !== false ? 'current-page' : '' }}" href="/training-consulting">Services</a></li>
                <li><a class="{{ strpos(Request::url(), '/clients') !== false ? 'current-page' : '' }}" href="/clients">Clients</a></li>
                <li><a class="{{ strpos(Request::url(), '/contact') !== false ? 'current-page' : '' }}" href="/contact">Contact</a></li>
            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li class="social-media">
                    <a href="https://twitter.com/SportsBizBob"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a href="https://instagram.com/sportsbizsol"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/in/bob-hamer-b1ab703"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                </li>
                <li class="divider"></li>
                <li><a href="/about">About</a></li>
                <li><a href="/training-consulting">Services</a></li>
                <li><a href="/clients" class="">Clients</a></li>
                <li><a href="/contact" class="">Contact</a></li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse button-collapse-default"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
        </div>
    </nav>
    @yield('subnav')
    @include('layouts.components.breadcrumb')
</header>
