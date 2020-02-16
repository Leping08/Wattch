@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between m-2">
            <div>
                <span class="page-heading pb-2">Results</span>
            </div>
            <div>
                <span class="mdi mdi-clipboard-pulse-outline text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>

        <div class="w-full mt-4">
            <div class="card text-gray-700 bg-white p-4 w-full rounded-bl-none rounded-br-none">
                <div class="mb-4 flex">
                    <div class="flex">
                        @if($result->success)
                            <span class="mdi mdi-message-text-outline text-teal-600 text-lg pr-4"></span>
                        @else
                            <span class="mdi mdi-message-alert-outline text-red-700 text-lg pr-4"></span>
                        @endif
                    </div>
                    <div class="flex-1">
                        @if($result->success)
                            <span class="text-gray-600">Success</span>
                        @else
                            <span class="text-gray-700">{{$result->error_message}}</span>
                        @endif
                    </div>
                </div>
                <div class="">
                    <span class="mdi mdi-clock-check-outline text-gray-600 text-lg pr-4"></span> <span class="text-gray-600">{{$result->created_at->diffForHumans()}}, at {{$result->created_at}}</span>
                </div>
            </div>
            <div class="w-full rounded-bl-lg rounded-br-lg">
                <div class="py-1 rounded-bl-lg rounded-br-lg h-3 {{ $result->success ? 'bg-teal-500' : 'bg-red-700' }}"></div>
            </div>
        </div>

        <div class="mt-4">
            @include('pages.auth.components.cards.assertion', ['assertion' => $result->assertion])
        </div>

        <div class="mt-4">
            @include('pages.auth.components.cards.page', ['page' => $result->assertion->page])
        </div>
    </div>
@endsection
