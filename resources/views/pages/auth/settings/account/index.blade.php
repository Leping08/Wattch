@extends('pages.auth.settings.layout')

@section('heading')
    Account Settings
@endsection

@section('settings_content')
    <div class="flex">
        <div class="flex-1">
            <form method="POST" action="{{ route('settings.account.store') }}">
                @csrf
                <div class="flex flex-wrap mb-6">
                    <label for="name" class="block text-gray-600 text-sm font-bold mb-2">
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

                    <input id="password" type="password" class="input {{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required>

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

                    <input id="password_confirmation" type="password" class="input {{ $errors->has('password_confirmation') ? ' border-red-500' : '' }}" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('password_confirmation') }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center">
                    <button type="submit" class="btn-teal">
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="mx-8 h-96">
            <img alt="" class="h-full" src="/img/icons/undraw_profile_data_mk6k.svg">
        </div>
    </div>
@endsection
