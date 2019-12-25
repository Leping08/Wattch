@extends('pages.auth.settings.layout')

@section('heading')
    Billing Settings
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
        <div class="flex mx-8 h-96">
            <img alt="" class="h-full" src="/img/icons/undraw_pay_online_b1hk.svg">
        </div>
    </div>
@endsection
