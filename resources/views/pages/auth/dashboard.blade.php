@extends('layouts.app')

@section('content')
    <div class="">
        <div class="flex">
            @php
                $items = [
                    [
                        'title' => 'Websites',
                        'icon' => 'monitor-dashboard',
                        'value' => $websites_count,
                        'link' => route('websites.index')
                    ],
                    [
                        'title' => 'Assertions',
                        'icon' => 'check',
                        'value' => $assertions_count,
                        'link' => '#'
                    ],
                    [
                        'title' => 'Alerts',
                        'icon' => 'bell-outline',
                        'value' => 0,
                        'link' => '#'
                    ],
                ]
            @endphp

            @foreach($items as $item)
                <a href="{{$item['link']}}" class="card w-1/2 flex justify-between items-center bg-white h-24 text-center mx-2">
                    <div class="ml-4">
                        <div class="pb-2">
                            <span class="italic text-gray-700 font-bold text-2xl">{{$item['value']}}</span>
                        </div>
                        <div>
                            <span class="italic text-gray-600 text-xl">{{$item['title']}}</span>
                        </div>
                    </div>
                    <div class="p-3 mr-4">
                        <span class="mdi mdi-{{$item['icon']}} text-teal-600 text-3xl"></span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="flex">
            <div class="card w-full bg-white mx-2 mt-4 flex">
                <div class="w-full border-r border-gray-300">
                    <dashboard-chart success-counts="{{$assertions_success_by_day}}" fail-counts="{{$assertions_fails_by_day}}"></dashboard-chart>
                </div>
                <div class="w-1/3 flex flex-col justify-around">
                    <div class="border-b border-gray-300 h-full">
                        <div class="flex flex-col justify-between h-full">
                            <div></div>
                            <div class="text-center">
                                <div>
                                    <div class="pb-2">
                                        <span class="mdi mdi-checkbox-multiple-marked-circle-outline text-teal-500 text-3xl"></span>
                                    </div>
                                    <div class="pb-2">
                                        <span class="italic text-gray-700 font-bold text-2xl">
                                            <count-up :to="{{ $assertions_success_by_day->sum() }}"></count-up>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="italic text-gray-600">Successful Assertions</span>
                                    </div>
                                </div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <div class="h-full">
                        <div class="flex flex-col justify-between h-full">
                            <div></div>
                            <div class="text-center">
                                <div>
                                    <div class="pb-2">
                                        <span class="mdi mdi-bell-ring-outline text-red-500 text-3xl"></span>
                                    </div>
                                    <div class="pb-2">
                                        <span class="italic text-gray-700 font-bold text-2xl">
                                            <count-up :to="{{ $assertions_fails_by_day->sum() }}"></count-up>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="italic text-gray-600">Failed Assertions</span>
                                    </div>
                                </div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="card w-full bg-white mx-2 mt-4">
                @include('pages.auth.components.tables.dashbaord_assertions_table')
            </div>
        </div>
    </div>
@endsection
