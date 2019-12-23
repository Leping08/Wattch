@extends('pages.auth.settings.layout')

@section('heading')
    Notifications Settings
@endsection

@section('settings_content')
    <div class="flex">
        <div class="flex-1">
            <form method="POST" action="{{ route('settings.account.store') }}">
                @csrf


                <div class="flex flex-wrap items-center">
                    <button type="submit" class="btn-teal">
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="mx-8 h-96">
            <img alt="" class="h-full" src="/img/icons/undraw_notify_88a4.svg">
        </div>
    </div>
@endsection
