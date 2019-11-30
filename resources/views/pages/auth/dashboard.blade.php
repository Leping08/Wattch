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
            <div class="card w-full bg-white mx-2 mt-4">
                <dashboard-chart success-counts="{{$assertions_success_by_day}}" fail-counts="{{$assertions_fails_by_day}}"></dashboard-chart>
            </div>
        </div>

        <div class="flex">
            <div class="card w-full bg-white mx-2 mt-4">
                @include('pages.auth.components.tables.dashbaord_assertions_table')
            </div>
        </div>
    </div>
@endsection
