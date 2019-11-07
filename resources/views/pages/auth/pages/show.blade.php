@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="m-3">
            <div class="flex justify-between m-4 mt-6">
                <div class="">
                    <h1 class="font-bold text-gray-700 text-xl p-2">{{ $page->fullRoute }}
                        <a href="{{ $page->fullRoute }}" target="_blank">
                            <span class="text-gray-600 mdi mdi-open-in-new"></span>
                        </a>
                    </h1>
                </div>
                <div class="">
                    <dropdown align="right" width="150px">
                        <template v-slot:trigger>
                            <button
                                class="card bg-white p-2 rounded-full text-lg focus:outline-none"
                                v-pre
                            >
                                <span class="mdi mdi-dots-vertical"></span>
                            </button>
                        </template>

                        <template v-slot:default>
                            <form method="POST" action="{{ route('scan.pages', ['page' => $page->id]) }}" >
                                @csrf
                                <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">Scan</button>
                            </form>

                            <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2" href="{{ route('websites.edit', ['website' => $page->id]) }}">Edit</a>
                            <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2" href="#delete-modal">Delete</a>
                        </template>
                    </dropdown>
                </div>
            </div>
            <div class="z-0">
                @if(count($page->screenshots))
                    <carousel :loop="true" :auto-play="true" :per-page="1" pagination-active-color="#38b1ac" pagination-color="#4a5568">
                        @foreach($page->screenshots as $screenshot)
                            <slide>
                                <img alt="" class="card" src="{{ asset($screenshot->src) }}">
                                <div class="card-overlap relative -mt-6 mx-2">
                                    <div class="flex flex-row items-center p-2">
                                        <div class="flex-1 text-center">
                                            <div class="flex flex-row mt-2">
                                                <div class="text-xl flex-1">
                                                    <span class="text-gray-600"><span class="mdi mdi-camera-outline"></span></span>
                                                    {{ $screenshot->created_at->format('m/d/y g:i a') }}
                                                    <span class="text-sm text-gray-600 italic">screenshot captured</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </slide>
                        @endforeach
                    </carousel>
                @else
                    <img alt="" class="card" src=""> {{--TODO Add placeholder image--}}
                @endif
            </div>
            <div class="">
                <div class="flex">
                    <div class="flex-1 mb-6">
                        <div class="card bg-white mt-6 mb-6 mr-3">
                            <page-chat :responses="{{ $page->http_responses }}"></page-chat>
                        </div>
                        <div class="card-overlap relative -mt-12 mx-2 mr-5">
                            <div class="flex flex-row items-center p-2">
                                <div class="flex-1 text-center">
                                    <div class="flex flex-row mt-2">
                                        <div class="text-xl flex-1">
                                            <span class="text-gray-600"><span class="mdi mdi mdi-clock-end mr-2"></span><span class="italic">Response Time</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 card bg-white mt-6 mb-6 ml-3">
                        <div class="text-center">
                            <div class="text-gray-600 italic">
                                Add stuff here
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="m-4 card bg-white">{{ $page->http_responses }}</div>--}}
            </div>
        </div>
    </div>

    <modal name="delete-modal">
        <h1 class="font-bold text-xl mb-4">Delete Page</h1>
        <p>Are you sure you want to delete the page <span class="text-teal-600 italic font-bold">{{ $page->route }}</span> ?</p>
        <template v-slot:footer>
            <a href="#" class="btn-teal mr-2">Cancel</a>
            <a href="#" class="btn-teal bg-red-500 hover:bg-red-600">Delete</a> {{--TODO Get delete to work--}}
        </template>
    </modal>
@endsection