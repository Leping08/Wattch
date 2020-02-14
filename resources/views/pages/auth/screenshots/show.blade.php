@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between m-2 align-middle">
            <div>
                <span class="page-heading">Screenshot</span>
            </div>
            <div class="flex">
                <span class="text-gray-600 mr-2">
                    <span class="mdi mdi-camera-outline text-xl"></span>
                </span>
                <span class="text-lg text-gray-700">{{ $screenshot->created_at->format('m/d/y g:i a') }}</span>
            </div>
            <div>
                <span class="mdi mdi-image-outline text-2xl text-teal-600"></span>
            </div>
        </div>

        <div class="w-full mt-4">
            <div class="card w-full">
                <img class="rounded-lg" src="{{ asset($screenshot->src) }}">
            </div>
        </div>
    </div>
@endsection
