<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | Sports Business Solutions</title>
        <!-- CSS  -->
        <link href="/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="/css/app.css" type="text/css" rel="stylesheet"/>
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body>
        <nav class="red darken-1" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="/" class="brand-logo">Logo</a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="/services">Services</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/blog">Blog</a></li>
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><a href="/user/profile">{{ Auth::user()->name }}</a></li>
                        <li>
                            <a href="{{ route('logout') }}">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li><a href="/services">Services</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/blog">Blog</a></li>
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><a href="/user/profile">{{ Auth::user()->name }}</a></li>
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
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <footer class="page-footer red">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Sports Business Solutions</h5>
                        <p class="grey-text text-lighten-4">We help people succeed in sports business by providing training, consulting, and recruiting services for sports teams and career cervices for those interested in working in sports.</p>
                    </div>
                    <div class="col l3 s12">
                        <h5 class="white-text">Services</h5>
                        <ul>
                            <li><a class="white-text" href="/services">Services</a></li>
                            <li><a class="white-text" href="/blog">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col l3 s12">
                        <h5 class="white-text">Connect</h5>
                        <ul>
                            <li><a class="white-text" href="/about">About</a></li>
                            <li><a class="white-text" href="/contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    Designed by <a class="red-text text-lighten-3" href="http://materializecss.com">Materialize</a> | Developed by <a class="red-text text-lighten-3" href="https://whale.enterprises">Whale Enterprises</a>
                </div>
            </div>
        </footer>
        <!--  Scripts-->
        <script type="text/javascript" src="/js/jquery-2.2.4.min.js"></script>
        <script type="text/javascript" src="/js/materialize.min.js"></script>
        <script type="text/javascript" src="/js/sbs.js"></script>
    </body>
</html>
