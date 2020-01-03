@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">
                <script src="https://js.stripe.com/v3/" type="application/javascript"></script>
                <div class="flex flex-col card bg-gray-100">

                    <div class="bg-teal-600 px-4 py-2 rounded-t-lg shadow">
                        <span class="font-bold text-gray-200 no-underline">Sign Up</span>
                    </div>

                    <div class="p-4">
                        <img alt="" class="w-full" src="/img/wattch_guy/undraw_experience_design_eq3j.svg">
                    </div>

                    <form class="w-full p-6" id="payment_form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="flex flex-wrap mb-6">
                            <label for="name" class="block text-gray-600 text-sm font-bold mb-2">
                                <span class="mdi mdi-account-outline mr"></span> {{ __('Name') }}:
                            </label>

                            <input id="name" type="text" class="input {{ $errors->has('name') ? ' border-red-500' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

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
                            <p class="w-full text-xs text-center text-gray-700 mt-6 -mb-10">
                                Already have an account?
                                <a class="text-teal-500 hover:text-teal-700 no-underline" href="{{ route('login') }}">
                                    Login
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
