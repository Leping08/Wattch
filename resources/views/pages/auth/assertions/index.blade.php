@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        <div class="flex justify-between m-2">
            <div>
                <span class="page-heading pb-2">Assertions</span>
            </div>
            <div>
                <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>

        <div class="card bg-gray-100 mb-6 overflow-hidden">
            @forelse($assertions as $assertion)
                @include('pages.auth.components.list.assertion-with-page-image')
            @empty
                <div>

                </div>
            @endforelse
        </div>
        <div class="flex justify-around">
            {{ $assertions->links() }}
        </div>
    </div>
@endsection
