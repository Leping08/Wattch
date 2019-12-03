@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex flex-wrap">
            <div class="flex justify-between m-2 pb-4">
                <div>
                    <h1 class="font-bold text-gray-600 text-xl p-2">@yield('heading')</h1>
                </div>
            </div>
        </div>

        @include('pages.auth.settings.tab_nav')

        <div class="bg-gray-100 card p-4 shadow">
            @yield('settings_content')
        </div>
    </div>
@endsection
