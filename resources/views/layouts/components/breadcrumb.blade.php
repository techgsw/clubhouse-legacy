@if (isset($breadcrumb))
    <nav>
        <div class="nav-wrapper container">
            <div class="col s12">
                @foreach ($breadcrumb as $text => $url)
                    <a href="{{ $url }}" class="breadcrumb">{{ $text }}</a>
                @endforeach
            </div>
        </div>
    </nav>
@endif
