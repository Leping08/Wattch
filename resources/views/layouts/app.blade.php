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
    <div class="">
        <div>
            @include('layouts.top_nav')
        </div>
        <div class="flex h-full">
            <div>
                @if (Auth::check())
                    <div class="fixed mt-0 lg:mt-16 w-0 lg:w-64 min-h-screen bg-gray-100 shadow-md pt-4 hidden lg:block">
                        @include('layouts.side_nav')
                    </div>
                @endif
            </div>
            <div class="mt-16 w-full {{Auth::check() ? 'ml-0 lg:ml-64' : ''}}">
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
