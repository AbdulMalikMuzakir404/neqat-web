<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    @yield('title')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.css.style')

    @stack('styles')

</head>

<body>
    <div id="app" style="display: none;">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('layouts.navbar')

            @include('layouts.sidebar')

            <!-- Main Content -->
            @yield('content')

            @include('layouts.footer')
        </div>
    </div>

    @include('components.loading.loading')

    @include('layouts.js.script')

    @stack('scripts')

</body>

</html>
