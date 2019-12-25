<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css">

    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/img/wattch_guy/wattch_guy.png') }}">
</head>
<body class="bg-gray-200 h-screen antialiased leading-none">

<div id="app">
    <div class="h-screen">
        <div>
            @include('layouts.top_nav')
        </div>
        <div class="flex">
            <div>
                @if (Auth::check())
                    @include('layouts.side_nav')
                @endif
            </div>
            <div class="mt-16 p-4 w-full {{Auth::check() ? 'ml-64' : ''}}">
                @yield('content')
            </div>
        </div>
        @if (!Auth::check())
            <div>
                @include('layouts.footer')
            </div>
        @endif
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
