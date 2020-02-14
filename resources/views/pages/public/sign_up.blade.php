@extends('layouts.app')

@section('content')
    @php
        $products = [
            [
                'id' => 1,
                'name' => 'Babysitter',
                'price' => 999,
                'icon' => '/img/icons/undraw_baby_ja7a.svg',
                'features' => [
                    '10 Websites',
                    'Assertions/6 Hours',
                    'Screenshots',
                    'Downtime Alerts'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Security Guard',
                'price' => 3499,
                'icon' => '/img/icons/undraw_security_o890.svg',
                'features' => [
                    '100 Websites',
                    'Assertions/Hourly',
                    'Screenshots',
                    'Downtime Alerts',
                    'SSL Monitoring',
                    'Domain Expiration Monitoring',
                ]
            ],
            [
                'id' => 3,
                'name' => 'Private Investigator',
                'price' => 9999,
                'icon' => '/img/icons/undraw_surveillance_kqll.svg',
                'features' => [
                    '1000 Websites',
                    'Assertions/10 Min',
                    'Screenshots',
                    'Downtime Alerts',
                    'SSL Monitoring',
                    'Domain Expiration Monitoring',
                    '3 Month Record Retention',
                    'Assertions API'
                ]
            ]
        ];
    @endphp

    <form id="sign_up" method="POST" action="{{ route('sign-up.store') }}">
        @csrf
        <div class="relative">
            <img src="{{ asset('/img/blobs/blob-shape.svg') }}" class="absolute xl:visible lg:visible md:invisible sm:invisible invisible h-128" style="z-index: -25; top: 100px; right: 30px" alt="">
            <div class="w-full text-center pt-8 z-50">
                <div><span class="mdi mdi-tag-text-outline text-teal-600 lg:text-4xl md:text-3xl text-3xl"></span></div>
                <div class="text-center text-gray-700 italic lg:text-3xl text-2xl mt-2">Pricing</div>
                <div class="text-center text-gray-600 italic mt-2">No Contracts, no commitments, no fuss</div>
            </div>

            <div class="flex flex-col break-words bg-white border border-1 rounded-lg shadow-md lg:my-8 md:my-6 sm:my-4 my-4 z-10"></div>


            <sign-up-product-selector :products="{{ json_encode($products) }}"></sign-up-product-selector>

        </div>

        <div class="relative">
            <img src="{{ asset('/img/blobs/blob-shape.svg') }}" class="absolute xl:visible lg:visible md:invisible sm:invisible invisible h-96" style="z-index: -25; left: 20px; top: -100px; transform: rotate(280deg);" alt="">

            <div class="flex xl:flex-no-wrap lg:flex-no-wrap md:flex-no-wrap sm:flex-wrap flex-wrap xl:w-10/12 lg:w-4/5 md:w-full sm:w-full w-full mx-auto">
                <div class="w-full">
                    <script src="https://js.stripe.com/v3/" type="application/javascript"></script>
                    <div class="flex flex-col card bg-white xl:p-8 lg:p-8 md:p-8 sm:p-4 p-4 lg:m-4 md:m-2 sm:m-2 m-2">

                        <div class="w-full">

                            <div class="flex flex-wrap mb-6">
                                <label for="name" class="block text-gray-600 text-sm font-bold mb-2">
                                    <span class="mdi mdi-account-outline mr"></span> {{ __('Name') }}:
                                </label>

                                <input id="name" type="text" class="input {{ $errors->has('name') ? ' border-red-500' : '' }}" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <p class="text-red-500 text-xs italic mt-4">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex flex-wrap mb-6">
                                <label for="email" class="block text-gray-600 text-sm font-bold mb-2">
                                    <span class="mdi mdi-email-outline mr"></span> {{ __('E-Mail Address') }}:
                                </label>

                                <input id="email" type="email" class="input {{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <p class="text-red-500 text-xs italic mt-4">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex flex-wrap mb-6">
                                <label for="password" class="block text-gray-600 text-sm font-bold mb-2">
                                    <span class="mdi mdi-lock-outline mr"></span> {{ __('Password') }}:
                                </label>

                                <input id="password" type="password" class="input {{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <p class="text-red-500 text-xs italic mt-4">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex flex-wrap mb-6">
                                <label for="password-confirm" class="block text-gray-600 text-sm font-bold mb-2">
                                    <span class="mdi mdi-lock-outline mr"></span> {{ __('Confirm Password') }}:
                                </label>

                                <input id="password-confirm" type="password" class="input" name="password_confirmation" required>
                            </div>

                            <sign-up stripekey="{{ env('STRIPE_KEY') }}"></sign-up>

                            <div class="flex flex-wrap">
                                <p class="w-full text-xs text-center text-gray-600 mt-6">
                                    Already have an account?
                                    <a class="text-teal-500 hover:text-teal-700 no-underline" href="{{ route('login') }}">
                                        Login
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
