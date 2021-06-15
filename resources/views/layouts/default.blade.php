<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.components.head')
    <body class="sbs">
        @include('layouts.components.header')
        <main>
            @yield('hero')
            <div class="section no-pad-bot" id="index-banner">
                @yield('content')
            </div>
        </main>
        @include('layouts.components.footer')
        @include('layouts.components.scripts')
        @yield('scripts')
    </body>
</html>
