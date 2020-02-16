@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between">
            <div>
                <div class="page-heading p-2">{{ $page->full_route }}
                    <a href="{{ $page->full_route }}" target="_blank">
                        <span class="text-gray-600 mdi mdi-open-in-new"></span>
                    </a>
                </div>
            </div>
            <div>
                <dropdown align="right" width="150px">
                    <template v-slot:trigger>
                        <button class="card bg-white p-2 rounded-full text-lg focus:outline-none">
                            <span class="mdi mdi-dots-vertical"></span>
                        </button>
                    </template>

                    <template v-slot:default>
                        <form method="POST" action="{{ route('scan.pages', ['page' => $page->id]) }}">
                            @csrf
                            <button type="submit"
                                    class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">
                                Scan
                            </button>
                        </form>
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2"
                           href="#delete-modal">Delete</a>
                    </template>
                </dropdown>
            </div>
        </div>
        <div class="mt-2 p-2">
            @if(count($page->screenshots))
                <carousel :loop="true" :auto-play="true" :per-page="1" pagination-active-color="#38b1ac" pagination-color="#4a5568">
                    @foreach($page->screenshots as $screenshot)
                        <slide>
                            <img alt="" class="card object-cover object-top w-full h-screen" src="{{ asset($screenshot->src) }}">
                            <div class="card-overlap relative -mt-6 m-2">
                                <a href="{{ route('screenshots.show', ['screenshot' => $screenshot]) }}" class="flex p-4">
                                    <div class="flex-1 text-center">
                                        <span class="text-gray-600 mr-2">
                                            <span class="mdi mdi-camera-outline text-xl"></span>
                                        </span>
                                            <span class="text-lg text-gray-700">{{ $screenshot->created_at->format('m/d/y g:i a') }}</span>
                                    </div>
                                </a>
                            </div>
                        </slide>
                    @endforeach
                </carousel>
            @else
                <img alt="" class="card" src=""> TODO Add placeholder image
            @endif
        </div>

        <div class="lg:flex md:flex-wrap flex-wrap p-2">
            <div class="flex-1 lg:w-1/2 md:w-full w-full">
                <div class="card bg-white lg:mr-2 mr-0">
                    <div class="flex justify-between card-heading-border py-2 px-4">
                        <div>
                            <span class="card-heading pb-2">Response Time</span>
                        </div>
                        <div>
                            <span class="mdi mdi-clock-end text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                    <page-chat :responses="{{ $page->http_responses }}"></page-chat>
                </div>
            </div>
            <div class="flex-1 lg:w-1/2 md:w-full w-full">
                <div class="card bg-white lg:mt-0 mt-4 lg:ml-2 ml-0">
                    <a href="{{ route('pages.assertions.index', ['page' => $page]) }}">
                        <div class="flex justify-between card-heading-border py-2 px-4">
                            <div>
                                <span class="card-heading pb-2">Assertions</span>
                            </div>
                            <div>
                                <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
                            </div>
                        </div>
                    </a>
                    @forelse($page->assertions as $assertion)
                        @include('pages.auth.components.lists.assertion-no-page-image')
                    @empty
                        <div class="flex p-6">
                            <div class="flex-1"></div>
                            <div class="flex-1">
                                <a class="btn-teal" href="{{ route('pages.assertions.index', ['page' => $page]) }}">Add Assertion</a>
                            </div>
                            <div class="flex-1"></div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    <modal name="delete-modal">
        <div class="p-2">
            <div class="text-gray-600 italic">Are you sure you want to this page?</div>
            <div class="flex pt-4">
                <a href="#" class="btn-teal mr-2">Cancel</a>
                <form action="{{ route('pages.destroy', ['page' => $page]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn-teal text-red-500 border-red-500 hover:bg-red-500">Delete</button>
                </form>
            </div>
        </div>
    </modal>
@endsection
