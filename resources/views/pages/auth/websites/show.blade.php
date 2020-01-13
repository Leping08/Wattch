@extends('layouts.app')

@section('content')
    <div class="relative lg:p-4 md:p-2 sm:p-2 p-2">
        <div class="flex justify-between m-2">
            <div class="">
                <div class="page-heading">{{ $website->domain }}
                    <a href="{{ $website->domain }}" target="_blank"> <span class="text-gray-600 mdi mdi-open-in-new"></span></a>
                </div>
            </div>
            <div class="">
                <dropdown align="right" width="150px">
                    <template v-slot:trigger>
                        <button class="card bg-white p-2 rounded-full text-lg focus:outline-none">
                            <span class="mdi mdi-dots-vertical"></span>
                        </button>
                    </template>

                    <template v-slot:default>
                        <form method="POST" action="{{ route('scan.websites', ['website' => $website->id]) }}" >
                            @csrf
                            <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">Scan</button>
                        </form>
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2" href="#delete-modal">Delete</a>
                    </template>
                </dropdown>
            </div>
        </div>

        <div class="flex flex-wrap">
            @foreach($website->pages as $page)
                <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/3 p-2">
                    <a href="{{route('pages.show', ['page' => $page])}}">
                        <div class="mb-10">
                            @if($page->screenshots->last())
                                <img class="object-contain rounded-lg hover:shadow-md shadow" src="{{ asset($page->screenshots->last()->src) }}" alt="">
                            @else
                                <div class="rounded bg-white">
                                    <img class="object-contain rounded-lg hover:shadow-md h-56" src="/img/wattch_guy/undraw_online_test_gba7.svg" alt="">
                                </div>
                            @endif
                        </div>

                        <div class="bg-gray-100 rounded-lg hover:shadow-md shadow relative -mt-16 mx-2">
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
                                <div class="bg-teal-500 text-xs leading-none py-1 text-center text-white rounded-bl-lg rounded-br-lg h-3" style="width: 100%"></div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="absolute md:p-20 p-16 bottom-0 right-0">
        <a href="#new-page" class="fixed add-btn-teal">
            <span class="mdi mdi-plus text-2xl"></span>
        </a>
    </div>

    <modal name="new-page">
        <form action="{{ route('pages.store') }}" method="POST" class="p-2">
            @csrf()
            <label class="label" for="website">
                <span class="mdi mdi-laptop-chromebook"></span> Add Page
            </label>
            <div class="flex">
                <div class="mb-2 flex-1">
                    <input class="" id="website" type="hidden" name="website_id" value="{{ $website->id }}">
                    <input id="route" type="text" class="input {{ $errors->has('route') ? ' border-red-500' : '' }}" name="route" value="{{ old('route') }}" placeholder="/about-us" required>
                    @if ($errors->has('route'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('route') }}
                        </p>
                    @endif
                </div>
                <div>
                    <button type="submit" class="ml-4 btn-teal">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </modal>

    <modal name="delete-modal">
        <div class="p-2">
            <div class="text-gray-600 italic">Are you sure you want to delete <span class="text-blue-600 italic font-bold">{{ $website->domain }}</span> ?</div>
            <div class="flex pt-4">
                <a href="#" class="btn-teal mr-2">Cancel</a>
                <form action="{{ route('websites.destroy', ['website' => $website]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn-teal text-red-500 border-red-500 hover:bg-red-500">Delete</button>
                </form>
            </div>
        </div>
    </modal>
@endsection
