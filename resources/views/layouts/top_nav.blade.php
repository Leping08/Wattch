<div class="fixed w-full mx-auto top-0 z-20 shadow">
    <div class="flex items-center justify-center py-2 lg:p-2 md:p-2 sm:p-2 shadow-md bg-teal-600">
        <div class="flex">
            <a href="{{ Auth::check() ? route('dashboard') : route('home') }}" class="mr-6 flex items-center px-4">
                <img src="{{ asset('/img/wattch_guy/wattch_guy.svg') }}" class="flex-1 w-12 h-full object-cover object-center" alt="">
                <span class="text-2xl font-semibold text-white no-underline italic">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
        <div class="flex-1 text-right hidden lg:block">
            @guest
                <a class="no-underline hover:underline text-gray-100 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('sign-up.index'))
                    <a class="no-underline hover:underline text-gray-100 text-sm p-3" href="{{ route('sign-up.index') }}">{{ __('Sign Up') }}</a>
                @endif
            @else
                <a href="{{ route('settings.account.index') }}" class="text-white text-sm pr-4 hover:text-gray-300 hover:underline">{{ Auth::user()->name }}</a>
                <a href="{{ route('logout') }}" class="no-underline hover:underline text-gray-100 text-sm pr-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    {{ csrf_field() }}
                </form>
            @endguest
        </div>
        <div class="flex-1 text-right block lg:hidden relative">
            <mobile-nav>
                <template v-slot:nav>
                    <div>
                        @include('layouts.side_nav')
                    </div>
                </template>
            </mobile-nav>
        </div>
    </div>
</div>
