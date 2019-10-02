<nav class="bg-teal-600 shadow sticky top-0 z-50">
    <div class="container mx-auto">
        <div class="flex items-center justify-center py-4">
            <a href="{{ url('/') }}" class="mr-6 flex items-center">
                <img src="/img/icons/wattch_icon_teal.png" class="flex-1" alt="" style="max-width: 15%;">
                <span class="flex-1 text-2xl font-semibold text-white no-underline italic">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="flex-1 text-right">
                @guest
                    <a class="no-underline hover:underline text-gray-100 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="no-underline hover:underline text-gray-100 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <a href="{{ route('dashboard') }}" class="text-white text-sm pr-4 hover:text-gray-300 hover:underline">{{ __('Dashboard') }}</a>
                    <a href="{{ route('profile') }}" class="text-white text-sm pr-4 hover:text-gray-300 hover:underline">{{ Auth::user()->name }}</a>

                    <a href="{{ route('logout') }}" class="no-underline hover:underline text-gray-100 text-sm pr-4"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
<div class="mb-4"></div>
