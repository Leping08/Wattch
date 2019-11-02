@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap ">
            @foreach($websites as $website)
                <!--Metric Card-->
                <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/3 p-3">
                    <a href="{{route('websites.show', ['website' => $website])}}">
                        <div class="mb-10">
                            @if($website->home_page->screenshots->last())
                                <img class="object-contain rounded-lg hover:shadow-xl shadow"
                                     src="{{ asset($website->home_page->screenshots->last()->src) }}" alt="">
                            @else
                                <div class="rounded bg-white">
                                    <img class="object-contain rounded-lg hover:shadow-xl h-56"
                                         data-src="/img/icons/undraw_surveillance_kqll.svg" alt="">
                                </div>
                            @endif
                        </div>
                        <div class="bg-gray-100 rounded-lg hover:shadow-xl shadow relative -mt-16 mx-2">
                            <div class="flex flex-row items-center p-2">
                                <div class="flex-1 text-center">
                                    <div class="flex flex-row mt-2">
                                        <div class="text-xl flex-1">
                                            <span class="text-gray-600"><span class="mdi mdi-animation-outline"></span></span>
                                                {{ $website->pages->count() ?? '-' }}
                                            <span class="text-xs text-gray-600 italic">pages</span>
                                        </div>
                                        <div class="text-xl flex-1">
                                            <span class="text-gray-600"><span class="mdi mdi-lock"></span></span>
                                                {{ $website->latest_ssl_response->ssl_expires_in ?? '-' }}
                                            <span class="text-xs text-gray-600 italic">ssl expires</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php($goodPages = 0)

                            @foreach($website->pages as $page)
                                @if($page->latest_http_response)
                                    @if($page->latest_http_response->valid())
                                        @php($goodPages += 1)
                                    @endif
                                @endif
                            @endforeach

                            @if($website->pages->count())
                                @php($percent = (($goodPages / $website->pages->count()) * 100))
                            @else
                                @php($percent = 0)
                            @endif

                            <div class="shadow w-full bg-red-700 rounded-bl-lg rounded-br-lg">
                                <div
                                    class="bg-teal-500 text-xs leading-none py-1 text-center text-white rounded-bl-lg h-3"
                                    style="width: {{{ $percent }}}%">
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
                <form action="{{ route('websites.store') }}" method="POST"
                      class="bg-white card p-6 mb-4">
                    @csrf()
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="website">
                        Add Website
                    </label>
                    <div class="flex">
                        <div class="mb-4 flex-1">
                            <input
                                class="input"
                                id="website" type="text" name="domain" placeholder="https://wattch.io/">
                        </div>
                        <div>
                            <button type="submit" class="ml-4 btn-teal">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
