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

        <div class="w-full mt-4 flex">
            <div class="card text-gray-700 bg-white p-4 w-full">
                <div class="mb-4">
                    @if($result->success)
                        <span class="text-sm text-gray-600 italic">Status</span> <span class="text-2xl mdi mdi-checkbox-marked-circle-outline text-teal-500"></span>
                    @else
                        <span class="text-sm text-gray-600 italic">Status</span> <span class="text-2xl mdi mdi-close-circle-outline text-red-500"></span>
                    @endif
                </div>
                <div class="mb-4">
                    @if($result->success)
                        <span class="text-sm text-gray-600 italic">Message</span> Success
                    @else
                        <span class="text-sm text-gray-600 italic">Message</span> <span class="mdi mdi-bell-alert-outline text-gray-600 text-lg"></span> {{$result->error_message}}
                    @endif
                </div>
                <div class="mb-4">
                    <span class="text-sm text-gray-600 italic">Result</span> <span class="text-gray-800">{{$result->created_at->diffForHumans()}}, at {{$result->created_at}}</span>
                </div>
            </div>
        </div>

        <div class="mt-4">
            @include('pages.auth.components.card.page', ['page' => $result->assertion->page])
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
                    <div class="p-4">
                        <div class="text-blue-600 italic mb-4">
                            <span class="mdi mdi-file-document-box-outline text-gray-600 text-lg"></span> {{$result->assertion->page->fullRoute}}
                        </div>
                        <div class="mb-4">
                            <span class="mdi mdi-format-list-checks text-gray-600 text-lg"></span> <span class="text-gray-600">{{$result->assertion->type->method}}(</span><span class="text-purple-700">{{\Illuminate\Support\Str::limit(implode(' ', $result->assertion->parameters), 1000)}}</span><span class="text-gray-600">)</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
