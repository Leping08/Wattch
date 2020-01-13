@extends('layouts.app')

@section('content')
    <div class="flex content-center flex-wrap justify-center h-screen bg-gray-300">
        <div class="lg:w-1/3 md:w-1/2 sm:w-2/3 w-2/3">
            <img src="{{ asset('img/wattch_guy/undraw_not_found_60pq.svg') }}" alt="">
            <div class="text-2xl italic text-gray-600 text-center pt-8">assertStatus(404)</div>
        </div>
    </div>
@endsection