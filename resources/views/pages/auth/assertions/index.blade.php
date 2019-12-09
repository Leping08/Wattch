@extends('layouts.app')

@section('content')
    <div class="mx-auto">

        <div class="flex justify-between m-2">
            <h1 class="font-bold text-gray-600 text-xl p-2">Assertions</h1>
        </div>

        <div class="card bg-gray-100 mb-6">
            @forelse($assertions as $assertion)
                <div class="flex hover:bg-gray-300">
                    <div class="text-center mx-6 my-2">
                        <div>
                            <img class="h-18 w-32 rounded shadow" alt="" src="{{$assertion->page->latest_screenshot->src}}">
                        </div>
                    </div>
{{--                    <div class="flex flex-col justify-around mx-6">--}}
{{--                        <div>--}}
{{--                            <span class="text-lg mdi {{$assertion->latest_result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="flex flex-auto flex-col justify-around mx-6">
                        <div class="text-blue-700 text-sm italic">
                            {{$assertion->page->fullRoute}}
                        </div>
                        <div class="text-gray-700">
                            {{$assertion->type->method}} {{\Illuminate\Support\Str::limit(implode(' ', $assertion->parameters))}}
                        </div>
                    </div>
                    <div class="flex flex-col justify-around mx-6">
                        <div class="text-gray-700 text-sm">
                            {{$assertion->created_at->diffForHumans()}}
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </div>
@endsection
