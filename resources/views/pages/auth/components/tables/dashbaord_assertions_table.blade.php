<div class="overflow-y-auto rounded-lg overflow-auto h-64 scrollbar-w-2 scrollbar-track-gray-lighter scrollbar-thumb-rounded scrollbar-thumb-gray scrolling-touch text-gray-600 italic">
    <table class="w-full text-left table-collapse">
        <thead>
            <tr class="bg-gray-100 shadow">
                <th class="text-sm font-semibold text-gray-600 p-2">Status</th>
                <th class="text-sm font-semibold text-gray-600 p-2">Page</th>
                <th class="text-sm font-semibold text-gray-600 p-2">Method</th>
                <th class="text-sm font-semibold text-gray-600 p-2">Prams</th>
                <th class="text-sm font-semibold text-gray-600 p-2">Time</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            @forelse($latest_assertions as $assertion_result)
                <tr>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap"><span class="text-lg mdi {{$assertion_result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span></td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion_result->assertion->page->fullRoute}}</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion_result->assertion->type->method}}</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{\Illuminate\Support\Str::limit(implode(' ', $assertion_result->assertion->parameters), 50)}}</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion_result->created_at->diffForHumans()}}</td>
                </tr>
            @empty
                <tr>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap">--</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                    <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">--</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

