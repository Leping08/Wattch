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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css">

    <link rel="icon" type="image/png" sizes="96x96" href="/img/icons/wattch_icon_teal.png">
</head>
<body class="bg-gray-200 h-screen antialiased leading-none">

    <div id="app">

        <div class="min-h-screen flex flex-col">

            @include('layouts.navbar')

            <div class="flex-grow">
                @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
