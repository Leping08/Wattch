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
                    <div class="">
                        <div class="text-gray-600 italic">
                            <div
                                class="overflow-y-auto scrollbar-w-2 scrollbar-track-gray-lighter scrollbar-thumb-rounded scrollbar-thumb-gray scrolling-touch rounded-lg">
                                <table class="w-full text-left table-collapse">
                                    <thead>
                                    <tr>
                                        <th class="text-sm font-semibold text-gray-700 p-2 bg-gray-100">Status</th>
                                        <th class="text-sm font-semibold text-gray-700 p-2 bg-gray-100">Method</th>
                                        <th class="text-sm font-semibold text-gray-700 p-2 bg-gray-100">Prams</th>
                                        <th class="text-sm font-semibold text-gray-700 p-2 bg-gray-100">Time</th>
                                    </tr>
                                    </thead>
                                    <tbody class="align-baseline">
                                    @forelse($page->assertions as $assertion)
                                        <tr>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap"><span class="text-lg mdi {{$assertion->latest_result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span></td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion->type->method}}</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{implode(' ', $assertion->parameters)}}</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion->latest_result->created_at->diffForHumans()}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap">Add an assertion</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                                            <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/1 pl-3">
                    <form action="{{ route('pages.store') }}" method="POST" class="bg-white card p-6 mb-4">
                        @csrf()
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="route">
                            Add Assertion
                        </label>

                        <div class="mb-4 flex">
                            <div class="inline-block relative w-64">
                                <select class="block appearance-none w-full bg-white input px-4 py-2 pr-8">
                                    @forelse($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @empty
                                        <option>--</option>
                                    @endforelse
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>

                            <div class="pl-4">
                                <input class="input flex-1" id="route" type="text" name="route" placeholder="assertSee">
                            </div>
                            <input class="" id="website" type="hidden" name="page_id" value="{{ $page->id }}">
                            <button type="submit"
                                    class="btn-teal ml-4">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
