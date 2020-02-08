<a href="{{ route('assertions.show', ['assertion' => $assertion]) }}" class="flex hover:bg-gray-300 border-b">
    <div class="text-center mx-6 my-2">
        <div>
            <img class="h-18 w-32 rounded shadow" alt="" src="{{$assertion->page->latest_screenshot->src ?? asset('img/wattch_guy/undraw_online_test_gba7.svg')}}">
        </div>
    </div>
    <div class="flex flex-auto flex-col justify-around mx-6">
        <div class="text-blue-600 text-sm italic">
            {{$assertion->page->fullRoute}}
        </div>
        <div class="">
            <span class="text-gray-600">{{$assertion->type->method}}(</span><span class="text-purple-700">{{\Illuminate\Support\Str::limit(implode(' ', $assertion->parameters), 50)}}</span><span class="text-gray-600">)</span>
        </div>
    </div>
    <div class="flex flex-col justify-around mx-6">
        <assertion-sparkline-chart :results="{{$assertion->results}}"></assertion-sparkline-chart>
    </div>
    <div class="flex flex-col justify-around mx-6">
        <div class="text-gray-700 text-sm">
            {{$assertion->created_at->diffForHumans()}}
        </div>
    </div>
</a>
