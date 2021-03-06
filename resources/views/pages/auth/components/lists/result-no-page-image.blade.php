<a href="{{ route('results.show', ['result' => $result]) }}" class="flex hover:bg-gray-300 border-b border-gray-300 cursor-pointer h-24">
    <div class="flex flex-col justify-around mx-6">
        <div>
            <span class="text-lg mdi {{$result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span>
        </div>
    </div>
    <div class="flex flex-auto flex-col justify-around mx-6">
        <div class="text-blue-600 text-sm italic">
            {{$result->assertion->page->fullRoute}}
        </div>
        <div class="">
            <span class="text-gray-600">{{$result->assertion->type->method}}(</span><span class="text-purple-700">{{\Illuminate\Support\Str::limit(implode(' ', $result->assertion->parameters))}}</span><span class="text-gray-600">)</span>
        </div>
    </div>
    <div class="flex flex-col justify-around mx-6">
        <div class="text-gray-600 text-sm">
            {{$result->created_at->diffForHumans()}}
        </div>
    </div>
</a>
