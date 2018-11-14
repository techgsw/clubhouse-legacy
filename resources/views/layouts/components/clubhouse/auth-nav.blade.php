<nav class="nav-user hide-on-med-and-down nav-custom-desktop" role="navigation">
    <div class="nav-wrapper container">
        <ul>
            <li><a href="{{ env('APP_URL') }}" class="no-underline"><img style="height: 30px; margin-top: 5px;" src="/images/logo-simple.png" alt="Sports Business Solutions"></a></li>
            @can ('view-admin-dashboard')
                <li><a href="/admin">ADMIN</a></li>
            @endif
        </ul>
        <ul class="right">
            <li><a href="https://facebook.com/sportsbusinesssolutions"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a></li>
            <li><a href="https://twitter.com/SportsBizSol"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a></li>
            <li><a href="https://instagram.com/sportsbizsol"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a></li>
            <li><a href="https://www.linkedin.com/company/sports-business-solutions"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a></li>
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ env('CLUBHOUSE_URL') }}" class="sbs-red white-text">Register</a></li>
            @else
                <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
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
