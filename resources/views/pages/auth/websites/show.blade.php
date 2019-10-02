@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between m-4 mt-6">
            <div class="">
                <h1 class="font-bold text-gray-700 text-xl p-2">{{ $website->domain }}
                    <a href="{{ $website->domain }}" target="_blank">
                        <span class="text-gray-600 mdi mdi-open-in-new"></span>
                    </a>
                </h1>
            </div>
            <div class="">
                <dropdown align="right" width="150px">
                    <template v-slot:trigger>
                        <button
                            class="no-underline focus:outline-none hover:bg-white rounded-full hover:shadow p-2 cursor-pointer text-xl text-gray-700"
                            v-pre
                        >
                            <span class="mdi mdi-dots-vertical"></span>
                        </button>
                    </template>

                    <template v-slot:default>
                        <form method="POST" action="{{ route('scan.websites', ['website' => $website->id]) }}" >
                            @csrf
                            <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">Scan</button>
                        </form>

                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2" href="{{ route('websites.edit', ['website' => $website->id]) }}">Edit</a>
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2" href="#delete-modal">Delete</a>
                    </template>
                </dropdown>
            </div>

        </div>

        <div class="flex flex-wrap ">
            @foreach($website->pages as $page)
                <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/3 p-3">
                    <!--Metric Card-->
                    <a href="{{route('pages.show', ['page' => $page])}}">
                        <div class="mb-10">
                            @if($page->screenshots->last())
                                <img class="object-contain rounded-lg hover:shadow-xl shadow"
                                     src="{{ asset($page->screenshots->last()->src) }}" alt="">
                            @else
                                <div class="rounded bg-white">
                                    <img class="object-contain rounded-lg hover:shadow-xl h-56"
                                         src="/img/icons/undraw_surveillance_kqll.svg" alt="">
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-100 rounded-lg hover:shadow-xl shadow relative -mt-16 mx-2">
                            <div class="flex justify-center pt-2 italic">
                                <div class="text-gray-600 text-sm">
                                    {{ $page->route }}
                                </div>
                            </div>
                            <div class="flex flex-row items-center pb-2">
                                <div class="flex-1 text-center">
                                    <div class="flex flex-row mt-2">
                                        <div class="text-xl flex-1">
                                            <span class="text-gray-600"><span
                                                    class="mdi mdi-server-network"></span></span>
                                            {{ $page->latest_http_response->response_code ?? '--' }}
                                            <span class="text-xs text-gray-600 italic">code</span>
                                        </div>
                                        <div class="text-xl flex-1">
                                            <span class="text-gray-600"><span class="mdi mdi-clock-end"></span></span>
                                            {{ $page->latest_http_response->total_time ?? '--' }}
                                            <span class="text-xs text-gray-600 italic">time</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shadow w-full bg-red-700 rounded-bl-lg rounded-br-lg">
                                <div
                                    class="bg-teal-500 text-xs leading-none py-1 text-center text-white rounded-bl-lg rounded-br-lg h-3"
                                    style="width: {{ $page->latest_http_response->valid() ? '100' : '0' }}%">
                                </div>
                            </div>
                        </div>
                    </a>
                    <!--/Metric Card-->
                </div>
            @endforeach
        </div>

        <div class="flex flex-wrap ">
            <div class="w-full sm:w-1/1 p-3">
                <form action="{{ route('pages.store') }}" method="POST"
                      class="bg-white rounded-lg shadow-md hover:shadow-xl p-8 mb-4">
                    @csrf()
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="route">
                            Watch Page
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="route" type="text" name="route" placeholder="/about-us">
                        <input class="" id="website" type="hidden" name="website_id" value="{{ $website->id }}">
                    </div>
                    <button type="submit"
                            class="bg-teal-500 hover:bg-teal-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Submit
                    </button>
                </form>
            </div>
        </div>

        <modal name="delete-modal">
            <h1 class="font-bold text-xl mb-4">Delete Website</h1>
            <p>Are you sure you want to delete <span class="text-gray-600 italic font-bold">{{ $website->domain }}</span> ?</p>
            <template v-slot:footer>
                <a href="#" class="bg-gray-600 py-2 px-4 rounded text-white hover:bg-gray-700 mr-2 shadow">Cancel</a>
                <a href="#" class="bg-red-600 hover:bg-red-700 py-2 px-4 rounded text-white shadow">Delete</a>
            </template>
        </modal>

    </div>
@endsection
