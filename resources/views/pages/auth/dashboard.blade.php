@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="">
            <div class="">

                @if (session('status'))
                    <div
                        class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
                        role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                <div class="flex flex-wrap">
                    @foreach($items as $index => $item)
                        <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/4 p-3">
                            <!--Metric Card-->
                            <a href="{{{$item['link']}}}">
                                @php
                                    if($item['total']){
                                        $percent = (round(($item['valid_count'] / $item['total']), 2) * 100);
                                    } else {
                                        $percent = 0;
                                    }
                                @endphp
                                <div class="mb-10">
                                    <div class="rounded bg-white rounded-lg hover:shadow-xl shadow flex justify-center">
                                        <img class="object-contain h-56 pb-8 p-2"
                                             src="{{ $item['image'] }}" alt="">
                                    </div>
                                </div>

                                <div class="bg-gray-100 rounded-lg hover:shadow-xl shadow relative -mt-16 mx-2">
                                    <div class="flex justify-center p-2">
                                        <div class="text-xl text-gray-600 italic">{{ $item['title'] }}</div>
                                    </div>

                                    <div class="shadow w-full bg-red-700 rounded-bl-lg rounded-br-lg">
                                        <div
                                            class="bg-teal-500 text-xs leading-none py-1 text-center text-white rounded-bl-lg h-3"
                                            style="width: {{ $percent }}%">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!--/Metric Card-->
                        </div>
                    @endforeach
                </div>


                <div class="flex flex-wrap ">
                    <div class="w-full md:w-1/1 xl:w-1/2 p-3">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-md hover:shadow-lg">
                            <div class="bg-gray-700 border-b-4 border-teal-500 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold text-white">Graph</h5>
                            </div>
                            <div class="p-5">
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>

                    <div class="w-full md:w-1/1 xl:w-1/2 p-3">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-md hover:shadow-lg">
                            <div class="bg-gray-700 border-b-4 border-teal-500 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold text-white">Graph</h5>
                            </div>
                            <div class="p-5">
                            </div>
                        </div>
                        <!--/Graph Card-->
                    </div>
                </div>
                <div class="pt-4 pb-4">
                    <form action="/analyze-site" method="POST">
                        @csrf()
                        <button type="submit"
                                class="bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold py-2 px-4 border border-gray-400 shadow">
                            Scan All Sites
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
