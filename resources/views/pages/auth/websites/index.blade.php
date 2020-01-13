@extends('layouts.app')

@section('content')
    <div class="relative lg:p-4 md:p-2 sm:p-2 p-2">
        <div class="flex justify-between m-2">
            <div class="">
                <span class="page-heading">Websites</span>
            </div>
            <div>
                <span class="mdi mdi-monitor-cellphone text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>
        <div class="flex flex-wrap">
            @foreach($websites as $website)
                <!--Metric Card-->
                <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/3 p-2">
                    <a href="{{route('websites.show', ['website' => $website])}}">
                        <div class="mb-10">
                            @if($website->home_page->latest_screenshot)
                                <img class="object-contain rounded-lg hover:shadow-md shadow" src="{{ asset($website->home_page->latest_screenshot->src) }}" alt="">
                            @else
                                <div class="rounded bg-white">
                                    <img class="object-contain rounded-lg hover:shadow-md h-56 w-full pb-8" src="{{ asset('img/wattch_guy/undraw_online_test_gba7.svg') }}" alt="">
                                </div>
                            @endif
                        </div>
                        <div class="bg-gray-100 rounded-lg hover:shadow-md shadow relative -mt-20 mx-2">
                            <div class="flex w-full justify-center pt-2">
                                <span class="text-gray-800 text-sm italic">{{ $website->domain }}</span>
                            </div>
                            <div class="flex flex-row items-center p-1">
                                <div class="flex-1 text-center">
                                    <div class="flex flex-row mt-2">
                                        <div class="text-xl flex-1">
                                            <span class="text-gray-600"><span class="mdi mdi-file-document-box-multiple-outline"></span></span>
                                                {{ $website->pages->count() ?? '-' }}
                                            <span class="text-xs text-gray-600 italic">pages</span>
                                        </div>
                                        @if($website->latest_ssl_response)
                                            @if($website->latest_ssl_response->ssl_expires_in > 0)
                                                <div class="text-xl flex-1">
                                                    <span class="text-gray-600"><span class="mdi mdi-lock-outline"></span></span> {{ $website->latest_ssl_response->ssl_expires_in ?? '-' }} <span class="text-xs text-gray-600 italic">ssl expires</span>
                                                </div>
                                            @else
                                                <div class="text-xl flex-1">
                                                    <span class="text-gray-600"><span class="mdi mdi-lock-open-variant-outline"></span></span> 0 <span class="text-xs text-gray-600 italic">ssl expired</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @php
                                if ($website->fails + $website->successes > 0) {
                                    $percent = (($website->successes / ($website->fails + $website->successes)) * 100);
                                } else {
                                    $percent = 100;
                                }
                            @endphp

                            <div class="shadow w-full bg-red-700 rounded-bl-lg rounded-br-lg">
                                <div class="bg-teal-500 text-xs leading-none py-1 text-center text-white rounded-bl-lg h-3 {{$percent > 97 ? 'rounded-br-lg' : ''}}" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </a>
                    <!--/Metric Card-->
                </div>
            @endforeach
        </div>
    </div>

    <div class="absolute md:p-20 p-16 bottom-0 right-0">
        <a href="#new-website" class="fixed add-btn-teal">
            <span class="mdi mdi-plus text-2xl"></span>
        </a>
    </div>

    <modal name="new-website">
        <form action="{{ route('websites.store') }}" method="POST" class="p-2">
            @csrf()
            <label class="label" for="website">
                <span class="mdi mdi-monitor-cellphone"></span> Add Website
            </label>
            <div class="flex">
                <div class="mb-2 flex-1">
                    <input id="website" type="text" class="input {{ $errors->has('website') ? ' border-red-500' : '' }}" name="website" value="{{ old('website') }}" placeholder="https://wattch.io/" required>
                    @if ($errors->has('website'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('website') }}
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
@endsection
