@if ($paginator->hasPages())
    <div class="flex items-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn-teal bg-gray-400 opacity-50 cursor-not-allowed mx-10">&laquo;</span>
        @else
            <a class="btn-teal bg-gray-100 mx-10" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="border border-teal-500 text-teal-500 bg-gray-300 rounded-lg px-3 py-2 cursor-not-allowed no-underline">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn-teal bg-teal-600 text-gray-100 mx-1">{{ $page }}</span>
                    @else
                        <a class="btn-teal bg-gray-100 mx-1" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn-teal bg-gray-100 mx-10" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
        @else
            <span class="btn-teal bg-gray-400 opacity-50 cursor-not-allowed mx-10">&raquo;</span>
        @endif
    </div>
@endif
