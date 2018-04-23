<!-- /resources/views/layouts/error.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.components.head')
    <body>
        @include('layouts.components.error-header')
        <main>
            @yield('hero')
            <div class="section no-pad-bot" id="index-banner">
                @yield('content')
            </div>
        </main>
    </body>
</html>
