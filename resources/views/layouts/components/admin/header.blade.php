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
                    <li><a href="/admin"><i class="fa fa-th" style="height: 40px; line-height: 40px;"></i></a></li>
                @endcan
                <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/blog">Blog</a></li>
                @can ('view-contact')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/admin/contact">Contacts</a></li>
                @endcan
                @can ('edit-email')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/email">Email</a></li>
                @endcan
                @can ('follow-up')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/admin/follow-up">Follow Up</a></li>
                @endcan
                @can ('view-admin-jobs')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/admin/job">Jobs</a></li>
                @endcan
                @can ('view-mentor')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/mentor">Mentors</a></li>
                @endcan
                @can ('view-admin-organizations')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/admin/organization">Organizations</a></li>
                @endcan
                @can ('admin-product')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/product/admin">Products</a></li>
                @endcan
                @can ('view-admin-questions')
                    <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/admin/question">Q&amp;A</a></li>
                @endcan
                <li><a style="font-size: 0.9em; text-transform: uppercase;" href="/session">Sessions</a></li>
            </ul>
        </div>
        <ul id="nav-mobile" class="side-nav">
            <li><a href="/">Home</a></li>
            <li class="divider"></li>
            @can ('view-admin-dashboard')
                <li><a href="/admin">Dashboard</a></li>
            @endcan
            <li><a href="/admin/job">Blog</a></li>
            @can ('view-contact')
                <li><a href="/admin/contact">Contacts</a></li>
            @endcan
            @can ('edit-email')
                <li><a href="/email">Email</a></li>
            @endcan
            @can ('view-admin-jobs')
                <li><a href="/admin/job">Jobs</a></li>
            @endcan
            @can ('view-mentor')
                <li><a href="/mentor">Mentors</a></li>
            @endcan
            @can ('view-admin-organizations')
                <li><a href="/admin/organization">Organizations</a></li>
            @endcan
            @can ('admin-product')
                <li><a href="/product/admin">Products</a></li>
            @endcan
            @can ('view-admin-questions')
                <li><a href="/admin/question">Q&amp;A</a></li>
            @endcan
            @can ('follow-up')
                <li><a href="/admin/follow-up">Follow Up</a></li>
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
    <div class="admin-breadcrumb hide-on-small-only">
        <div class="container">
            @include('layouts.components.breadcrumb')
        </div>
    </div>
</header>
