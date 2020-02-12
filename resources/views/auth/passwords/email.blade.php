@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">

                @if (session('status'))
                    <div class="text-sm border border-t-8 rounded text-gray-700 border-teal-600 bg-white p-4 my-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex flex-col break-words bg-gray-100 card my-6">

                    <div class="bg-teal-600 px-4 py-2 rounded-t-lg shadow">
                        <span class="card-heading text-gray-200">{{ __('Reset Password') }}</span>
                    </div>

                    <div class="p-4">
                        <img alt="" class="w-full" src="{{ asset('/img/wattch_guy/undraw_game_world_0o6q.svg') }}">
                    </div>

                    <form class="w-full p-6" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="flex flex-wrap mb-6">
                            <label for="email" class="label">
                                {{ __('E-Mail Address') }}:
                            </label>

                            <input id="email" type="email" class="input {{ $errors->has('email') ? ' border-red' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <p class="text-red-600 text-sm italic mt-4">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap">
                            <button type="submit" class="btn-teal">
                                {{ __('Send Password Reset Link') }}
                            </button>

                            <p class="w-full text-xs text-center text-grey-dark mt-8 -mb-4">
                                <a class="text-teal-600 hover:text-teal-700 no-underline" href="{{ route('login') }}">
                                    Back to login
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
