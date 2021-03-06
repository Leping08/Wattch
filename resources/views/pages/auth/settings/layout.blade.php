@extends('layouts.app')

@section('content')
    <div class="relative p-4">
        <div class="flex justify-between mb-4">
            <div>
                <span class="page-heading pb-2">Settings</span>
            </div>
            <div>
                <span class="mdi mdi-settings text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>

        @include('pages.auth.settings.tab_nav')

        <div class="bg-gray-100 card p-4 shadow rounded-tl-none">
            @yield('settings_content')
        </div>
    </div>
@endsection
