<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.components.head')
    <body>
        <header>
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
                            <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
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
        </header>
        <main>
            @include('layouts.components.breadcrumb')
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </main>
        @include('layouts.components.footer')
        @include('layouts.components.scripts')
    </body>
</html>
