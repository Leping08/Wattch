@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/1 flex-1 md:mx-auto p-6">

            @if (session('status'))
                <div
                    class="text-sm border border-t-8 rounded-lg text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
                    role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <div class="flex items-center mx-6">
                <div class="flex-1 px-6 text-left md:text-center xl:text-left inline-block align-text-bottom">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl xl:text-4xl font-light leading-tight">We Wattch so <span class="text-teal-500 font-normal">you don't have to</span></h1>
                    <p class="mt-6 leading-relaxed sm:text-lg md:text-xl xl:text-lg text-gray-600">
                        Wattch is a simple website monitoring platform that gives you peace of mind. Ensure your
                        websites and APIs are up and running at all times.
                    </p>
                    <div class="flex mt-6 justify-start md:justify-center xl:justify-start">
                        <a href="{{ route('sign-up.index') }}" class="rounded-lg px-4 md:px-5 xl:px-4 py-3 md:py-4 xl:py-3 bg-teal-500 hover:bg-teal-600 md:text-lg xl:text-base text-white font-semibold leading-tight shadow-md">Get Started</a>
                        <a href="" class="ml-4 rounded-lg px-4 md:px-5 xl:px-4 py-3 md:py-4 xl:py-3 bg-white hover:bg-gray-100 md:text-lg xl:text-base text-gray-800 font-semibold leading-tight shadow-md">Why Wattch?</a>
                    </div>
                </div>
                <div class="flex-1 mt-12 xl:mt-0 px-6">
                    <img class="w-2/3 float-right" src="/img/wattch_guy/undraw_server_down_s4lk.svg" alt="">
                </div>
            </div>

            <div class="flex flex-col break-words bg-white border border-1 rounded-lg shadow-md m-10 z-0">

            </div>

            @php
                $items = collect([
                    [
                        'name' => 'Analyze Your Data',
                        'icon' => 'undraw_detailed_analysis_xn7y.svg',
                        'content' => 'Get notified when any of the websites you are tracking go down through email, text, slack and many other integrations.',
                        'hashtags' => [
                            'intheknow',
                            '200',
                            'stable'
                        ]
                    ],
                    [
                        'name' => 'SSL Monitoring',
                        'icon' => 'undraw_security_o890.svg',
                        'content' => 'Make sure the SSL certificates for websites you are tracking are up to date and are valid.',
                        'hashtags' => [
                            'https',
                            'encryption',
                            'secure'
                        ]
                    ],
                    [
                        'name' => 'Content Matching',
                        'icon' => 'undraw_up_to_date_rmbm.svg',
                        'content' => 'Match the content from any http call, ensuring the content you want is properly being sent over the wire.',
                        'hashtags' => [
                            'ttd',
                            'assertsee'
                        ]
                    ],
                    [
                        'name' => 'API Testing',
                        'icon' => 'undraw_code_typing_7jnv.svg',
                        'content' => 'Test API endpoints and ensure they are returning the expected content.',
                        'hashtags' => [
                            'ttd',
                            'api',
                            'sleepingwell'
                        ]
                    ]
                ])
            @endphp


            <div class="md:w-1/1 flex md:mx-auto relative">
                @foreach($items as $key => $item)
                    <div class="flex-1 max-w-sm card bg-white overflow-hidden m-4">
                        <img class="w-full p-4" src="/img/icons/{{$item['icon']}}" alt="">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{$item['name']}}</div>
                            <p class="text-gray-700 text-base">{{$item['content']}}</p>
                        </div>
                        <div class="px-6 py-4">
                            @foreach($item['hashtags'] as $hashtag)
                                <span class="inline-block bg-gray-200 rounded-lg-full px-3 py-1 text-sm font-semibold text-gray-800 mr-2 shadow">#{{$hashtag}}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="flex flex-col break-words bg-white border border-1 rounded-lg shadow-md mt-8 mb-16"></div>


    <div class="container mx-auto px-4 mb-12">
        <div class="lg:flex lg:items-center lg:-mx-2">
            <div class="mb-4 lg:mb-0 lg:w-1/3 lg:px-2">
                <div class="text-center bg-white p-10 card">
                    <h2 class="text-lg mb-4 text-gray-800">Babysitter</h2>
                    <div class="mb-6">
                        <span class="text-xl text-gray-600">$</span>
                        <span class="text-3xl text-gray-800">10</span>
                        <span class="text-sm text-gray-600">/mo</span>
                    </div>
                    <div class="border-t border-solid text-sm pb-10">
                        <div class="text-center border-b py-4">
                            10 Websites
                        </div>
                        <div class="text-center border-b py-4">
                            Analytics
                        </div>
                        <div class="text-center border-b py-4">
                            Downtime Alerts
                        </div>
                    </div>
                    <a class="inline-block w-full p-3 border border-teal-500 rounded-lg px-4 md:px-5 xl:px-4 py-3 md:py-4 xl:py-3 bg-white hover:bg-teal-500 md:text-lg xl:text-base text-teal-500 hover:text-white font-semibold leading-tight shadow-md"
                       href="{{ route('sign-up.index') }}">Get started</a>
                </div>
            </div>

            <div class="mb-4 lg:mb-0 lg:w-1/3 lg:px-2">
                <div class="text-center bg-white py-16 p-10 card border border-teal-500">
                    <h2 class="text-lg mb-4 text-gray-800">Security Guard</h2>
                    <div class="mb-6">
                        <span class="text-xl text-gray-600">$</span>
                        <span class="text-3xl text-gray-800">20</span>
                        <span class="text-sm text-gray-600">/mo</span>
                    </div>
                    <div class="border-t border-solid text-sm pb-10">
                        <div class="text-center border-b py-4">
                            100 Websites
                        </div>
                        <div class="text-center border-b py-4">
                            API Endpoints
                        </div>
                        <div class="text-center border-b py-4">
                            SSL Monitoring
                        </div>
                    </div>
                    <a class="inline-block w-full p-3 border border-teal-600 rounded-lg px-4 md:px-5 xl:px-4 py-3 md:py-4 xl:py-3 bg-teal-500 hover:bg-teal-600 md:text-lg xl:text-base text-white hover:text-white font-semibold leading-tight shadow-md"
                       href="{{ route('sign-up.index') }}">Get started</a>
                </div>
            </div>

            <div class="mb-4 lg:mb-0 lg:w-1/3 lg:px-2">
                <div class="text-center bg-white p-10 card">
                    <h2 class="text-lg mb-4 text-gray-800">Private Investigator</h2>
                    <div class="mb-6">
                        <span class="text-xl text-gray-600">$</span>
                        <span class="text-3xl text-gray-800">49</span>
                        <span class="text-sm text-gray-600">/mo</span>
                    </div>
                    <div class="border-t border-solid text-sm pb-10">
                        <div class="text-center border-b py-4">
                            Website Tests
                        </div>
                        <div class="text-center border-b py-4">
                            API Tests
                        </div>
                        <div class="text-center border-b py-4">
                            Support
                        </div>
                    </div>
                    <a class="inline-block w-full p-3 border border-teal-500 rounded-lg px-4 md:px-5 xl:px-4 py-3 md:py-4 xl:py-3 bg-white hover:bg-teal-500 md:text-lg xl:text-base text-teal-500 hover:text-white font-semibold leading-tight shadow-md"
                       href="{{ route('sign-up.index') }}">Get started</a>
                </div>
            </div>
        </div>
    </div>
@endsection
