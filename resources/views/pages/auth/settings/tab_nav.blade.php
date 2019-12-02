@php
    $navitems = [
        [
            'name' => 'Account',
            'url' => route('settings.account.index'),
            'route_name' => 'dashboard',
            'icon' => 'account-badge-horizontal-outline',
            'selected' => \Illuminate\Support\Facades\Route::currentRouteName() === 'settings.account.index'
        ],
        [
            'name' => 'Notification',
            'url' => route('settings.notifications.index'),
            'route_name' => 'dashboard',
            'icon' => 'bell-outline',
            'selected' => \Illuminate\Support\Facades\Route::currentRouteName() === 'settings.notifications.index'
        ],
        [
            'name' => 'Billing',
            'url' => route('settings.billing.index'),
            'route_name' => 'dashboard',
            'icon' => 'credit-card-outline',
            'selected' => \Illuminate\Support\Facades\Route::currentRouteName() === 'settings.billing.index'
        ],
    ]
@endphp

<div class="flex">
    @foreach($navitems as $item)
        <a href="{{ $item['url'] }}" class="text-white text-justify no-underline italic text-gray-600 font-bold hover:text-gray-800 flex-grow-0 bg-gray-100 rounded-t-lg mx-4 {{ $item['selected'] ? 'text-gray-800 border-t-2 border-r-2 border-l-2' : '' }}">
            <div class="leading-tight py-2 text-sm px-8 hover:bg-gray-300 rounded-t-lg {{ $item['selected'] ? '' : 'border-b-2' }}">
                <span class="mr-4 mdi mdi-{{ $item['icon'] }} text-lg {{ $item['selected'] ? 'text-teal-600' : 'text-gray-500' }}"></span> {{ $item['name'] }}
            </div>
        </a>
    @endforeach
</div>
