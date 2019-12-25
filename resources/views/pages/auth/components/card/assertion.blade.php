<a href="{{ route('assertions.show', ['assertion' => $assertion]) }}">
    <div class="card bg-white">
        <div class="flex justify-between card-heading-border py-2 px-4">
            <div>
                <span class="card-heading pb-2">Assertion</span>
            </div>
            <div>
                <span class="mdi mdi-format-list-checks text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>
        <div class="p-4 flex">
            <div class="flex">
                <img class="h-24 pr-4" alt="" src="{{ $assertion->type->icon_path }}">
            </div>
            <div class="flex-1">
                <div class="text-blue-600 italic mb-4">
                    <span class="mdi mdi-file-document-box-outline text-gray-600 text-lg"></span> {{$assertion->page->fullRoute}}
                </div>
                <div class="italic mb-4">
                    <span class="mdi mdi-format-list-checks text-gray-600 text-lg"></span> <span class="text-gray-600">{{$assertion->type->method}}(</span><span class="text-purple-700">{{\Illuminate\Support\Str::limit(implode(' ', $assertion->parameters), 1000)}}</span><span class="text-gray-600">)</span>
                </div>
                @if($assertion->muted())
                    <div class="text-gray-600 italic mb-4">
                        <span class="mdi mdi-bell-off-outline text-gray-600 text-lg"></span> Muted
                    </div>
                @else
                    <div class="text-gray-600 italic mb-4">
                        <span class="mdi mdi-bell-ring-outline text-gray-600 text-lg"></span> Active
                    </div>
                @endif
            </div>
        </div>
    </div>
</a>
