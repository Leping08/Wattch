@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        <div class="flex justify-between m-2">
            <div>
                <span class="font-bold text-gray-600 text-xl pb-2">Result</span>
            </div>
            <div>
                <span class="mdi mdi-clipboard-pulse-outline text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>

        <div class="w-full mb-2 flex">
            <div class="card text-gray-700 bg-gray-100 p-4">
                @if($result->success)
                    <span class="text-2xl mdi mdi-checkbox-marked-circle-outline text-teal-500"></span>
                @else
                    <span class="text-2xl mdi mdi-close-circle-outline text-red-500"></span>
                @endif
            </div>
            <div class="card text-blue-600 italic bg-gray-100 p-4">
                {{$result->assertion->page->fullRoute}}
            </div>
            <div class="card">
                <img alt="" class="h-32 rounded shadow" src="{{asset($result->assertion->page->latest_screenshot->src)}}">
            </div>
        </div>
    </div>
@endsection
