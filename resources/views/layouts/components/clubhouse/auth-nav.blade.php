<nav class="nav-user hide-on-med-and-down nav-custom-desktop" role="navigation">
    <div class="nav-wrapper container">
        <ul>
            <li><a href="{{ env('APP_URL') }}" class="no-underline"><img style="height: 30px; margin-top: 5px;" src="/images/SBSonly_logo.png" alt="SBS Consulting"></a></li>
            @can ('view-admin-dashboard')
                <li><a href="/admin">ADMIN</a></li>
            @endif
        </ul>
        <ul class="right">
            <li><a href="https://www.linkedin.com/company/the-clubhouse-sbs"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a></li>
            <li><a href="https://twitter.com/theC1ubhouse"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a></li>
            <li><a href="https://instagram.com/theC1ubhouse"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a></li>
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a class="sbs-red white-text modal-trigger" href="#register-modal">Register</a></li>
            @else
                <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
                @if (Auth::user()->profile && !Auth::user()->profile->isComplete())
                    <li><a class="tooltipped" data-tooltip="Your profile is still not complete! Click here to fill it out." href="/user/{{ Auth::user()->id }}/edit-profile"><i class="sbs-red-text material-icons">error_outline</i></a></li>
                @endif
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
