@extends('pages.auth.settings.layout')

@section('heading')
    Account Settings
@endsection

@section('settings_content')
    <div class="flex w-full">
        <form method="POST" class="flex-1" action="{{ route('settings.account.store') }}">
            @csrf

            <div>
                <product-selector :current="{{ json_encode($currentProduct) }}" :products="{{ json_encode($products) }}"></product-selector>
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="name" class="label">
                    <span class="mdi mdi-account-outline"></span> Name
                </label>

                <input id="name" type="text" class="input {{ $errors->has('name') ? ' border-red-500' : '' }}" name="name" value="{{ old('name') ?? $user->name }}" required autofocus>

                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-600 text-sm font-bold mb-2">
                    <span class="mdi mdi-email-outline"></span> Email
                </label>

                <input id="email" type="email" class="input {{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') ?? $user->email }}" required>

                @if ($errors->has('email'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="password" class="block text-gray-600 text-sm font-bold mb-2">
                    <span class="mdi mdi-lock-outline"></span> {{ __('Password') }}
                </label>

                <input id="password" type="password" class="input {{ $errors->has('password') ? ' border-red-500' : '' }}" name="password">

                @if ($errors->has('password'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="password_confirmation" class="block text-gray-600 text-sm font-bold mb-2">
                    <span class="mdi mdi-lock-outline"></span> {{ __('Password Confirmation') }}
                </label>

                <input id="password_confirmation" type="password" class="input {{ $errors->has('password_confirmation') ? ' border-red-500' : '' }}" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('password_confirmation') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap items-center">
                <button type="submit" class="btn-teal">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
        <div class="w-1/3 lg:block md:hidden sm:hidden hidden p-2">
            <img alt="" class="w-full" src="{{ asset('/img/icons/undraw_profile_data_mk6k.svg') }}">
        </div>
    </div>
@endsection
