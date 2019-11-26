<div class="fixed w-full mx-auto top-0 z-50 shadow">
    <div class="flex items-center justify-center py-2 lg:p-2 md:p-2 sm:p-2 shadow-md bg-teal-600">
        <div class="flex">
            <a href="{{ url('/') }}" class="mr-6 flex items-center px-4">
                <img src="/img/icons/wattch_icon_teal.png" class="flex-1 w-12 h-full object-cover object-center"
                     alt="">
                <span
                    class="flex-1 text-2xl font-semibold text-white no-underline italic">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
        <div class="flex-1 text-right">
            @guest
                <a class="no-underline hover:underline text-gray-100 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a class="no-underline hover:underline text-gray-100 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @else
                <a href="{{ route('profile') }}" class="text-white text-sm pr-4 hover:text-gray-300 hover:underline">{{ Auth::user()->name }}</a>
                <a href="{{ route('logout') }}" class="no-underline hover:underline text-gray-100 text-sm pr-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    {{ csrf_field() }}
                </form>
            @endguest
        </div>
    </div>
</div>
