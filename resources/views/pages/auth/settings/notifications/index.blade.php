@extends('pages.auth.settings.layout')

@section('heading')
    Notifications Settings
@endsection

@section('settings_content')
    <div class="flex">
        <div class="flex-1">
            <form method="POST" action="{{ route('settings.notifications.store') }}">
                @csrf
                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block text-gray-600 text-sm font-bold mb-2">
                        <toggle-button name="email_toggle" :height="16" color="#38b1ab" :value="{{ $muted_email_notifications ? 'false' : 'true' }}" :labels="{checked: 'On', unchecked: 'Off'}"></toggle-button> <span class="mdi mdi-email-outline ml-2"></span> Email
                    </label>

                    <input id="email" type="email" class="input {{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') ?? $notification_email_address }}" required>

                    @if ($errors->has('email'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

{{--                <div class="flex flex-wrap mb-6">--}}
{{--                    <label for="name" class="block text-gray-600 text-sm font-bold mb-2">--}}
{{--                        <toggle-button name="phone_toggle" :height="16" color="#38b1ab" :value="{{ 'true' }}" :labels="{checked: 'On', unchecked: 'Off'}"></toggle-button> <span class="mdi mdi-phone-outline ml-2"></span> Text Message--}}
{{--                    </label>--}}

{{--                    <input id="phone" type="tel" class="input {{ $errors->has('phone') ? ' border-red-500' : '' }}" name="phone" value="{{ old('phone') ?? '999-999-9999' }}" required autofocus>--}}

{{--                    @if ($errors->has('phone'))--}}
{{--                        <p class="text-red-500 text-xs italic mt-4">--}}
{{--                            {{ $errors->first('slack_webhook') }}--}}
{{--                        </p>--}}
{{--                    @endif--}}
{{--                </div>--}}

                <div class="flex flex-wrap mb-6">
                    <label for="name" class="block text-gray-600 text-sm font-bold mb-2">
                        <toggle-button name="slack_toggle" :height="16" color="#38b1ab" :value="{{ $muted_slack_notifications ? 'false' : 'true' }}" :labels="{checked: 'On', unchecked: 'Off'}"></toggle-button> <span class="mdi mdi-slack ml-2"></span> Slack Webhook
                    </label>

                    <input id="slack_webhook" type="text" class="input {{ $errors->has('slack_webhook') ? ' border-red-500' : '' }}" name="slack_webhook" value="{{ old('slack_webhook') ?? $slack_webhook_url }}">

                    @if ($errors->has('slack_webhook'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('slack_webhook') }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center">
                    <button type="submit" class="btn-teal">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="w-1/3 lg:block md:hidden sm:hidden hidden">
            <img alt="" class="w-full" src="/img/icons/undraw_notify_88a4.svg">
        </div>
    </div>
@endsection
