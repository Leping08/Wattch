<div>
    <div class="card bg-white flex-1">
        <div class="flex justify-between py-2 px-4 card-heading-border">
            <div>
                <span class="card-heading pb-2">Results</span>
            </div>
            <div>
                <span class="mdi mdi-clipboard-pulse-outline text-2xl text-teal-600 align-bottom"></span>
            </div>
        </div>
        <div>
            <assertion-chart :results="{{$assertion->results}}"></assertion-chart>
        </div>
        <div class="border-t">
            @forelse($results as $result)
                @include('pages.auth.components.lists.result-no-page-image', ['result' => $result])
            @empty

            @endforelse
        </div>
        <div class="flex justify-around p-4">
            {{ $results->links() }}
        </div>
    </div>
</div>
