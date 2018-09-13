<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.components.head')
    <body>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                @yield('content')
            </div>
        </main>
        @include('layouts.components.scripts')
    </body>
</html>
