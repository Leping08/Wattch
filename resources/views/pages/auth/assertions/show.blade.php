@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        <div class="flex justify-between m-2">
            <div>
                <span class="page-heading pb-2">Assertions</span>
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
                        <form method="POST" action="">
                            @csrf
                            <button type="submit"
                                    class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">
                                Run
                            </button>
                        </form>

                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2"
                           href="#">Edit</a>
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2"
                           href="#delete-modal">Delete</a>
                    </template>
                </dropdown>
            </div>
        </div>

        <div class="mt-4">
            @include('pages.auth.components.card.page', ['page' => $assertion->page])
        </div>

        <div class="mt-4">
            @include('pages.auth.components.card.results', ['assertion' => $assertion])
        </div>
    </div>
@endsection
