<div class="overflow-y-auto scrollbar-w-2 scrollbar-track-gray-lighter scrollbar-thumb-rounded scrollbar-thumb-gray scrolling-touch rounded-lg text-gray-600 italic">
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
                @if($assertion->latest_result)
                    <tr>
                        <td class="p-2 border-t border-gray-300 font-mono text-xs whitespace-no-wrap"><span class="text-lg mdi {{$assertion->latest_result->success ? 'mdi-checkbox-marked-circle-outline text-teal-500' : 'mdi-close-circle-outline text-red-500'}}"></span></td>
                        <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion->type->method}}</td>
                        <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{\Illuminate\Support\Str::limit(implode(' ', $assertion->parameters), 50)}}</td>
                        <td class="p-2 border-t border-gray-300 font-mono text-xs text-blue-700 whitespace-pre">{{$assertion->latest_result->created_at->diffForHumans()}}</td>
                    </tr>
                @endif
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
