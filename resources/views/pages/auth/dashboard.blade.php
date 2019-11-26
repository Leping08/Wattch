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
                <div class="">
                    <div class="text-gray-600 italic">
                        <div class="overflow-y-auto rounded-lg overflow-auto h-64 scrollbar-w-2 scrollbar-track-gray-lighter scrollbar-thumb-rounded scrollbar-thumb-gray scrolling-touch">
                            <table class="w-full text-left table-collapse">
                                <thead>
                                    <tr class="bg-gray-100 shadow">
                                        <th class="text-sm font-semibold text-gray-700 p-2">Status</th>
                                        <th class="text-sm font-semibold text-gray-700 p-2">Method</th>
                                        <th class="text-sm font-semibold text-gray-700 p-2">Prams</th>
                                        <th class="text-sm font-semibold text-gray-700 p-2">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="align-baseline">
                                    @forelse($latest_assertions as $assertion_result)
                                        <tr>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap"><span class="text-lg mdi {{$assertion_result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span></td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion_result->assertion->type->method}}</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{implode(' ', $assertion_result->assertion->parameters)}}</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion_result->created_at->diffForHumans()}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap">--</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
