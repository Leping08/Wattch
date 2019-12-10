@extends('layouts.app')

@section('content')
    <div class="mx-auto">

        <div class="flex justify-between m-2">
            <div>
                <span class="font-bold text-gray-600 text-xl pb-2">Assertion Results</span>
            </div>
            <div>
                <span class="mdi mdi-clipboard-pulse-outline text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>

        <div class="w-full mb-2">
            <script type="application/javascript">
                function formChanged(formId) {
                    let e = document.getElementById(formId);
                    let id = e.options[e.selectedIndex].value;
                    console.log(id);
                    let url = new URL(document.location.href);
                    url.searchParams.set(formId, id);
                    document.location.href = url.toString();
                }
            </script>
            <div class="flex">
                <div class="flex-1 mx-2 my-4">
                    <label for="website_id" class="block text-gray-600 text-sm font-bold mb-2">
                        Website
                    </label>

                    <div class="inline-block relative w-full">
                        <select onchange="formChanged('website_id');" id="website_id" name="website_id" class="block appearance-none w-full bg-white input px-4 py-2 pr-8 text-gray-600 cursor-pointer">
                            <option value="0">All</option>
                            @foreach($websites as $website)
                                <option value="{{$website->id}}" {{(Request::query('website_id') == $website->id) ? 'selected' : ''}}>{{$website->domain}}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1 mx-2 my-4">
                    <label for="page_id" class="block text-gray-600 text-sm font-bold mb-2">
                        Page
                    </label>
                    <div class="inline-block relative w-full">
                        <select onchange="formChanged('page_id');" id="page_id" name="page_id" class="block appearance-none w-full bg-white input px-4 py-2 pr-8 text-gray-600 cursor-pointer">
                            <option value="0">All</option>
                            @foreach($pages as $page)
                                <option value="{{$page->id}}" {{(Request::query('page_id') == $page->id) ? 'selected' : ''}}>{{$page->route}}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1 mx-2 my-4">
                    <label for="page_id" class="block text-gray-600 text-sm font-bold mb-2">
                        Status
                    </label>
                    <div class="inline-block relative w-full">
                        <select onchange="formChanged('status_id');" id="status_id" name="status_id" class="block appearance-none w-full bg-white input px-4 py-2 pr-8 text-gray-600 cursor-pointer">
                            @foreach($statuses as $status)
                                <option value="{{$status['id']}}" {{(Request::query('status_id') == $status['id']) ? 'selected' : ''}}>{{$status['name']}}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card bg-gray-100 mb-6">
            @forelse($assertion_results as $assertion_result)
                <a href="{{ route('results.show', ['result' => $assertion_result]) }}" class="flex hover:bg-gray-300 border-b border-gray-300 cursor-pointer">
                    <div class="text-center mx-6 my-2">
                        <div>
                            <img class="h-18 w-32 rounded shadow" alt="" src="{{$assertion_result->assertion->page->latest_screenshot->src}}">
                        </div>
                    </div>
                    <div class="flex flex-col justify-around mx-6">
                        <div>
                            <span
                                class="text-lg mdi {{$assertion_result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span>
                        </div>
                    </div>
                    <div class="flex flex-auto flex-col justify-around mx-6">
                        <div class="text-blue-700 text-sm italic">
                            {{$assertion_result->assertion->page->fullRoute}}
                        </div>
                        <div class="text-gray-700">
                            {{$assertion_result->assertion->type->method}}({{\Illuminate\Support\Str::limit(implode(' ', $assertion_result->assertion->parameters))}})
                        </div>
                    </div>
                    <div class="flex flex-col justify-around mx-6">
                        <div class="text-gray-700 text-sm">
                            {{$assertion_result->created_at->diffForHumans()}}
                        </div>
                    </div>
                </a>
            @empty
                <div>

                </div>
            @endforelse
        </div>

        <div class="flex justify-around">
            {{ $assertion_results->links() }}
        </div>
    </div>
@endsection
