<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.components.head')
    <body>
        @include('layouts.components.header')
        <main>
            @yield('hero')
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
