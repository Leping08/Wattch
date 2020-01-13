@if ($paginator->hasPages())
    <ul class="pagination flex justify-between mx-4 mt-4 list-reset text-gray-600 font-bold">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled p-2">
                <span class="btn-teal bg-gray-400 opacity-50 cursor-not-allowed">@lang('pagination.previous')</span>
            </li>
        @else
            <li class="p-2">
                <a class="btn-teal bg-gray-100" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="p-2">
                <a class="btn-teal bg-gray-100" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
            </li>
        @else
            <li class="disabled p-2">
                <span class="btn-teal bg-gray-400 opacity-50 cursor-not-allowed">@lang('pagination.next')</span>
            </li>
        @endif
    </ul>
@endif
