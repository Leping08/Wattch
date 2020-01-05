@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">
                <div class="flex flex-col break-words card bg-gray-100 mt-6">

                    <div class="bg-teal-600 px-4 py-2 rounded-t-lg shadow">
                        <span class="font-bold text-gray-200 no-underline">Login</span>
                    </div>

                    <div class="p-4">
                        <img alt="" class="w-full" src="/img/wattch_guy/undraw_team_collaboration_8eoc.svg">
                    </div>

                    <form class="w-full p-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="flex flex-wrap mb-6">
                            <label for="email" class="block text-gray-600 text-sm font-bold mb-2">
                                <span class="mdi mdi-email-outline mr"></span> {{ __('E-Mail Address') }}:
                            </label>

                            <input id="email" type="email" class="input {{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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

                        <div class="flex mb-6">
                            <input class="form-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="text-sm text-gray-600 ml-3" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="flex flex-wrap items-center">
                            <button type="submit" class="btn-teal">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-teal-600 hover:text-teal-700 whitespace-no-wrap no-underline ml-auto" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <p class="w-full text-xs text-center text-gray-600 mt-8 -mb-4">
                                    Don't have an account?
                                    <a class="text-teal-600 hover:text-teal-700 no-underline" href="{{ route('sign-up.index') }}">
                                        Sign Up
                                    </a>
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
