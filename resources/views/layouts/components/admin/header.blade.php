<header>
    <nav class="nav-user hide-on-med-and-down" role="navigation">
        <div class="nav-wrapper container">
            <ul>
                <li><a href="/">Home</a></li>
            </ul>
            <ul class="right">
                <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
                <li>
                    <a href="{{ route('logout') }}">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="nav-admin" role="navigation">
        <div class="nav-wrapper container">
            <ul class="hide-on-med-and-down">
                @can ('view-admin-dashboard')
                    <li><a href="/admin">Dashboard</a></li>
                @endcan
                @can ('view-admin-users')
                    <li><a href="/admin/user">Users</a></li>
                @endcan
                @can ('view-admin-questions')
                    <li><a href="/admin/question">Q&amp;A</a></li>
                @endcan
                @can ('view-admin-jobs')
                    <li><a href="/admin/job">Job Board</a></li>
                @endcan
                @can ('create-post')
                    <li><a href="/post/create">New Blog Post</a></li>
                @endcan
            </ul>
        </div>
        <ul id="nav-mobile" class="side-nav">
            <li><a href="/">Home</a></li>
            <li class="divider"></li>
            @can ('view-admin-dashboard')
                <li><a href="/admin">Dashboard</a></li>
            @endcan
            @can ('view-admin-users')
                <li><a href="/admin/user">Users</a></li>
            @endcan
            @can ('view-admin-questions')
                <li><a href="/admin/question">Q&amp;A</a></li>
            @endcan
            @can ('view-admin-jobs')
                <li><a href="/admin/job">Job Board</a></li>
            @endcan
            <li class="divider"></li>
            <li><a href="/user/{{ Auth::user()->id }}">{{ Auth::user()->getName() }}</a></li>
            <li>
                <a href="{{ route('logout') }}">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
    </nav>
</header>
