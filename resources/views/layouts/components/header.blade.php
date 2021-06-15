<header>
    <nav class="nav-main" role="navigation" style="height:85px;line-height:unset;">
        <div class="nav-wrapper container">
            <a id="logo-container" href="/" class="brand-logo">
                <img src="/images/sbs_consulting_logo.png" alt="SBS Consulting">
            </a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/about">About</a></li>
                <li><a href="/training-consulting">Services</a></li>
                <li><a href="/clients">Clients</a></li>
                <li><a href="/contact">Contact</a></li>
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
    <div class="row hero" style="background-color:#eee;padding:10px 20px;line-height:1.8rem;">
        <h5 style="font-weight:500;">Get sales and leadership best practices. <a class="sbs-newsletter-cta" href="#footer-newsletter">Subscribe to our newsletter</a></h5>
    </div>
    @include('layouts.components.breadcrumb')
</header>
