@extends('layouts.app')

@section('content')
    <div class="mx-auto">
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
            <a href="{{ route('assertions.show', ['assertion' => $result->assertion]) }}">
                <div class="card bg-white">
                    <div class="flex justify-between card-heading-border py-2 px-6">
                        <div>
                            <span class="card-heading pb-2">Assertion</span>
                        </div>
                        <div>
                            <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                    <div class="p-4 flex">
                        <div class="flex">
                            <img class="h-24 pr-4" alt="" src="{{ $result->assertion->type->icon_path }}">
                        </div>
                        <div class="flex-1">
                            <div class="text-blue-600 italic mb-4">
                                <span class="mdi mdi-file-document-box-outline text-gray-600 text-lg"></span> {{$result->assertion->page->fullRoute}}
                            </div>
                            <div class="mb-4">
                                <span class="mdi mdi-format-list-checks text-gray-600 text-lg"></span> <span class="text-gray-600">{{$result->assertion->type->method}}(</span><span class="text-purple-700">{{\Illuminate\Support\Str::limit(implode(' ', $result->assertion->parameters), 1000)}}</span><span class="text-gray-600">)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="mt-4">
            @include('pages.auth.components.card.page', ['page' => $result->assertion->page])
        </div>

    </div>
@endsection
