<a href="{{ route('pages.show', $page) }}">
    <div class="card bg-white">
        <div class="flex justify-between card-heading-border py-2 px-4">
            <div>
                <span class="card-heading pb-2">Page</span>
            </div>
            <div>
                <span class="mdi mdi-file-document-box-outline text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>
        <div class="flex">
            <div class="text-center mx-6 my-2">
                <div>
                    <img class="rounded shadow object-cover object-top w-32 h-18" alt="" src="{{ asset($page->latest_screenshot->src) }}">
                </div>
            </div>
            <div class="flex w-full text-center">
                <div class="flex-1 mx-6">
                    <div class="flex flex-col justify-between h-full">
                        <div></div>
                        <div class="text-center">
                            <span class="text-blue-600 text-sm italic">{{ $page->full_route ?? '--' }}</span>
                        </div>
                        <div></div>
                    </div>
                </div>
                <div class="flex-1 mx-6">
                    <div class="flex flex-col justify-between h-full">
                        <div></div>
                        <div class="text-center">
                            <span class="text-gray-600"><span class="mdi mdi-server-network"></span></span>
                            <span class="text-lg text-gray-800">{{ $page->latest_http_response->response_code ?? '--' }}</span>
                            <span class="text-xs text-gray-600 italic">code</span>
                        </div>
                        <div></div>
                    </div>
                </div>
                <div class="flex-1 mx-6">
                    <div class="flex flex-col justify-between h-full">
                        <div></div>
                        <div class="text-center">
                            <span class="text-gray-600"><span class="mdi mdi-clock-end"></span></span>
                            <span class="text-lg text-gray-800">{{ $page->latest_http_response->total_time ?? '--' }}</span>
                            <span class="text-xs text-gray-600 italic">time</span>
                        </div>
                        <div></div>
                    </div>
                </div>
                <div class="flex-1 mx-6">
                    <div class="flex flex-col justify-between h-full">
                        <div></div>
                        <div class="text-center">
                            <span class="text-gray-600"><span class="mdi mdi-lan-pending"></span></span>
                            <span class="text-lg text-gray-800">{{ $page->latest_http_response->ip ?? '--' }}</span>
                            <span class="text-xs text-gray-600 italic">ip</span>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="w-full bg-red-700 rounded-bl-lg rounded-br-lg">--}}
{{--            <div class="bg-teal-500 py-1 rounded-bl-lg rounded-br-lg h-3" style="width: {{ $page->latest_http_response->valid() ? '100' : '0' }}%"></div>--}}
{{--        </div>--}}
    </div>
</a>
