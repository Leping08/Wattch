@extends('layouts.app')

@section('content')
    <div class="p-2">
        <div class="flex justify-between m-2">
            <div class="">
                <div class="page-heading p-2">{{ $page->fullRoute }}
                    <a href="{{ $page->fullRoute }}" target="_blank">
                        <span class="text-gray-600 mdi mdi-open-in-new"></span>
                    </a>
                </div>
            </div>
            <div class="">
                <dropdown align="right" width="150px">
                    <template v-slot:trigger>
                        <button
                            class="card bg-white p-2 rounded-full text-lg focus:outline-none"
                            v-pre
                        >
                            <span class="mdi mdi-dots-vertical"></span>
                        </button>
                    </template>

                    <template v-slot:default>
                        <form method="POST" action="#" >
                            @csrf
                            <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">Scan All</button>
                        </form>
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2" href="">Delete All</a>
                    </template>
                </dropdown>
            </div>
        </div>

        <div class="flex">
            <div class="w-full card bg-white m-2">
                <div class="flex justify-between card-heading-border py-2 px-4">
                    <div>
                        <span class="card-heading pb-2">Add Assertion</span>
                    </div>
                    <div>
                        <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
                    </div>
                </div>
                <div class="">
                    <form action="{{ route('pages.assertions.store', ['page' => $page]) }}" method="POST" class="">
                        @csrf()
                        <input class="" id="website" type="hidden" name="page_id" value="{{ $page->id }}">
                        <div>
                            <add-assertion :types="{{ json_encode($types) }}"></add-assertion>
                        </div>
                        <div class="m-4">
                            <button type="submit" class="btn-teal">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="w-full card bg-white m-2">
                <div>
                    <div class="flex justify-between card-heading-border py-2 px-4">
                        <div>
                            <span class="card-heading pb-2">Assertions</span>
                        </div>
                        <div>
                            <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
                        </div>
                    </div>
                </div>
                <div>
                    @forelse($page->assertions as $assertion)
                        @include('pages.auth.components.lists.assertion-no-page-image')
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
