@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between m-2 align-middle">
            <div>
                <span class="page-heading">Response</span>
            </div>
            <div>
                <span class="mdi mdi-server-network text-2xl text-teal-600"></span>
            </div>
        </div>

        <div class="w-full">
            <div class="flex p-2">
                <div class="card bg-white w-full">
                    <div class="flex justify-between card-heading-border py-2 px-4">
                        <div>
                            <span class="card-heading pb-2">Benchmark</span>
                        </div>
                        <div>
                            <span class="mdi mdi-clock-start text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                    <div class="px-4 py-6">
                        @include('pages.auth.components.graphs.time_line', ['start' => 5, 'end' => 10, 'value' => $response->total_time])
                    </div>
                </div>
            </div>

            <div class="flex p-2">
                <div class="card bg-white w-full">
                    <div class="flex justify-between card-heading-border py-2 px-4">
                        <div>
                            <span class="card-heading pb-2">Breakdown</span>
                        </div>
                        <div>
                            <span class="mdi mdi-timeline-clock-outline text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="m-4 w-full shadow rounded-lg">
                            <table class="table-auto w-full rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-teal-600">
                                        <th class="px-4 py-2 text-left text-white italic">Event</th>
                                        <th class="px-4 py-2 text-left text-white italic">Time (sec)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <tr>
                                        <td class="px-4 py-2">Name Look Up</td>
                                        <td class="px-4 py-2">{{$response->request_stats_raw['namelookup_time'] ?? 'N/A'}}</td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="px-4 py-2">Connect</td>
                                        <td class="px-4 py-2">{{$response->request_stats_raw['connect_time'] ?? 'N/A'}}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="px-4 py-2">App Connect</td>
                                        <td class="px-4 py-2">{{$response->request_stats_raw['appconnect_time'] ?? 'N/A'}}</td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="px-4 py-2">Pre-transfer</td>
                                        <td class="px-4 py-2">{{$response->request_stats_raw['pretransfer_time'] ?? 'N/A'}}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="px-4 py-2">Start Transfer</td>
                                        <td class="px-4 py-2">{{$response->request_stats_raw['starttransfer_time'] ?? 'N/A'}}</td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="px-4 py-2">Total</td>
                                        <td class="px-4 py-2">{{$response->request_stats_raw['total_time'] ?? 'N/A'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex p-2">
                <div class="w-full">
                    @include('pages.auth.components.cards.page', ['page' => $response->page])
                </div>
            </div>
        </div>
    </div>
@endsection
