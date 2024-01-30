<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Neqat &mdash; Home</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.css.style')

</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            @include('layouts.navbar')

            @include('layouts.sidebar')

            <!-- Main Content -->
            @yield('content')

            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.js.script')

</body>

</html>
