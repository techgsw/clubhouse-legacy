<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.components.same-here-head')
<body>
@include('layouts.components.clubhouse.header')
<main>
    @yield('hero')
    <div class="section no-pad-bot" id="index-banner">
        @yield('content')
    </div>
    @if (Auth::guest())
        @include('components.register-modal')
    @endif
</main>
@include('layouts.components.clubhouse.footer')
@include('layouts.components.scripts')
@yield('scripts')
</body>
</html>
