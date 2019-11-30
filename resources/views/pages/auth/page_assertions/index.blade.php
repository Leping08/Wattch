@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="m-3">
            <div class="flex justify-between m-4 mt-6">
                <div class="">
                    <h1 class="font-bold text-gray-700 text-xl p-2">{{ $page->fullRoute }}
                        <a href="{{ $page->fullRoute }}" target="_blank">
                            <span class="text-gray-600 mdi mdi-open-in-new"></span>
                        </a>
                    </h1>
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
            <div class="flex-1">
                <div class="text-center card bg-white mt-6 mb-6 ml-3">
                    @include('pages.auth.components.tables.assertions_table')
                </div>
            </div>

            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/1 pl-3">
                    <form action="{{ route('pages.assertions.store', ['page' => $page]) }}" method="POST" class="bg-white card p-6 mb-4">
                        @csrf()
                        <input class="" id="website" type="hidden" name="page_id" value="{{ $page->id }}">
                        <label class="block text-gray-600 text-sm font-bold mb-2" for="assertion_type">
                            Add Assertion
                        </label>


                        <add-assertion :types="{{ json_encode($types) }}"></add-assertion>
                        <button type="submit" class="btn-teal">
                            Submit
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
