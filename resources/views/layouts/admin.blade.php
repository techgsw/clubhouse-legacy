<!-- /resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.components.clubhouse.head')
    <body>
        @include('layouts.components.admin.header')
        <main>
            @yield('hero')
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </main>
        @include('layouts.components.scripts')
    </body>
</html>
