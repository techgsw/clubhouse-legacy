@if (Auth::guest())
    <li><a href="{{ route('login') }}">Login</a></li>
    <li><a href="{{ route('register') }}"><span class="sbs-red">the</span>Clubhouse<sup>&#174;</sup></a></li>
@else
    <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
    <li>
        <a href="{{ route('logout') }}">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
@endif
