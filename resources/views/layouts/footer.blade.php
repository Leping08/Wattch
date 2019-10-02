<footer class="bg-gray-700 text-white bottom-0 w-full bottom-0">
    <div class="p-8 flex container mx-auto align-middle items-center">
        <a href="{{ url('/') }}" class="mr-6 flex items-center">
            <img src="/img/icons/wattch_icon_teal.png" class="flex-1" alt="" style="max-width: 15%;">
            <span class="flex-1 text-2xl font-semibold text-white no-underline italic">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <div class="flex-auto italic text-center text-gray-200 inline-block">
            Copyright © 2019 Wattch
        </div>
        <div class="flex-auto text-right text-gray-200">
            <ul class="">
                <li class="p-1"><a class="" href="">About</a></li>
                <li class="p-1"><a class="" href="">Contact Us</a></li>
                <li class="p-1"><a class="" href="">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</footer>
