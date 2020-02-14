<footer class="bg-gray-700 text-white w-full">
    <div class="p-8 flex container mx-auto align-middle items-center">
        <a href="{{ route('home') }}" class="flex-1 items-center">
            <div class="flex items-center">
                <img src="{{ asset('/img/wattch_guy/wattch_guy.svg') }}" class="h-16" alt="">
                <span class="text-2xl font-semibold text-white no-underline italic">{{ config('app.name', 'Laravel') }}</span>
            </div>
        </a>
        <div class="flex-1 italic text-center text-gray-200 inline-block">
            Copyright © {{ \Carbon\Carbon::now()->year }} Wattch
        </div>
        <div class="flex-1 text-right text-gray-200">
            <ul class="">
                <li class="p-1"><a class="" href="">About</a></li>
                <li class="p-1"><a class="" href="">Contact Us</a></li>
                <li class="p-1"><a class="" href="">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</footer>
