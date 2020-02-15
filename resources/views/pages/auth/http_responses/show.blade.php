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

        @php
            if($response->total_time > 10) {
                $total_time = 10;
            } else {
                $total_time = $response->total_time;
            }

            $total_time_percent = ($total_time / 10) * 100;
        @endphp

        <div class="w-full flex">
            <div class="card bg-gray-100 w-full p-4 m-2">
                <div class="card-heading mb-4">
                    Total Time
                </div>
                <div class="flex mb-4">
                    <div class="flex">
                        <div class="mr-2 -mt-1">0</div>
                    </div>
                    <div class="flex-1 relative">
                        <div class="w-full h-2 bg-green-500" style="background-image: linear-gradient(to right, #38b1ab, #ecc94b, #f56565);"></div>
                        <div class="absolute" style="margin-left: {{$total_time_percent}}%;">
                            <div class="mdi mdi-arrow-up-bold text-gray-600 text-2xl -ml-3"></div>
                        </div>
                    </div>
                    <div class="fle">
                        <div class="ml-2 -mt-1">10</div>
                    </div>
                </div>
                {{ $response->total_time }}
            </div>
            <div class="card bg-gray-100 w-full p-4 m-2">
                test
            </div>
        </div>
    </div>
@endsection
