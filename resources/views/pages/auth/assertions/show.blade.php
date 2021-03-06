@extends('layouts.app')

@section('content')
    <div class="lg:p-4 md:p-2 sm:p-2 p-2">
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
                        <form method="POST" action="{{ route('assertions.run.index', ['assertion' => $assertion]) }}">
                            @csrf
                            <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">
                                Run
                            </button>
                        </form>

                        @if($assertion->muted)
                            <form method="POST" action="">
                                @csrf
                                <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">
                                    Unmute
                                </button>
                            </form>
                        @else
                            <form method="POST" action="">
                                @csrf
                                <button type="submit" class="block no-underline w-full text-left italic text-gray-600 hover:bg-gray-300 p-2">
                                    Mute
                                </button>
                            </form>
                        @endif
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2"
                           href="#">Edit</a>
                        <a class="block no-underline italic text-gray-600 hover:bg-gray-300 p-2"
                           href="#delete-modal">Delete</a>
                    </template>
                </dropdown>
            </div>
        </div>

        <div class="w-full mt-4">
            @include('pages.auth.components.cards.assertion', ['assertion' => $assertion])
        </div>

        <div class="mt-4">
            @include('pages.auth.components.cards.page', ['page' => $assertion->page])
        </div>

        <div class="mt-4">
            @include('pages.auth.components.cards.results', ['assertion' => $assertion])
        </div>
    </div>
@endsection
