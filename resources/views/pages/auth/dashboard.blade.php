@extends('layouts.app')

@section('content')
    <div class="p-2">
        <div class="flex my-2">
            @php
                $items = [
                    [
                        'title' => 'Websites',
                        'icon' => 'monitor-cellphone',
                        'value' => $websites_count,
                        'link' => route('websites.index')
                    ],
                    [
                        'title' => 'Assertions',
                        'icon' => 'format-list-checks',
                        'value' => $assertions_count,
                        'link' => route('assertions.index')
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
            <div class="card w-full bg-white m-2 flex">
                <div class="w-full border-r border-gray-300">
                    <dashboard-chart success-counts="{{$assertions_success_by_day}}" fail-counts="{{$assertions_fails_by_day}}"></dashboard-chart>
                </div>
                <div class="w-1/3 flex flex-col justify-around">
                    <a href="{{ route('results.index', ['status_id' => 1]) }}" class="border-b border-gray-300 h-full cursor-pointer hover:shadow-md">
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
                    </a>
                    <div class="h-full">
                        <a href="{{ route('results.index', ['status_id' => 2]) }}" class="flex flex-col justify-between h-full cursor-pointer hover:shadow-md">
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
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="card bg-white overflow-hidden w-full m-2">
                <a href="{{ route('assertions.index') }}" class="card-heading-border py-2 px-6 cursor-pointer flex justify-between">
                    <div>
                        <span class="card-heading pb-2">Assertions</span>
                    </div>
                    <div>
                        <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
                    </div>
                </a>
                @forelse($latest_assertions as $assertion)
                    @include('pages.auth.components.lists.assertion-with-page-image')
                @empty

                @endforelse
            </div>
        </div>
    </div>
@endsection
