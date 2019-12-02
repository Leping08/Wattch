@extends('pages.auth.settings.layout')

@section('heading')
    Account Settings
@endsection

@section('settings_content')
    <div class="bg-gray-100 card p-4 shadow">
        <form method="POST" >
            @csrf
            <div class="flex flex-wrap mb-6">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                    Name
                </label>

                <input id="name" type="text" class="input {{ $errors->has('name') ? ' border-red-500' : '' }}" name="email" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                    Email
                </label>

                <input id="email" type="email" class="input {{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('Password') }}:
                </label>

                <input id="password" type="password" class="input {{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
@endsection
