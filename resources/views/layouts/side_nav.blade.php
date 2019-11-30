<div class="fixed mt-16 w-64 min-h-screen bg-gray-100 shadow-md pt-4">
    <ul class="list-reset">
        @php
            $items = [
                [
                    'name' => 'Dashboard',
                    'url' => route('dashboard'),
                    'route_name' => 'dashboard',
                    'icon' => 'view-dashboard'
                ],
                [
                    'name' => 'Websites',
                    'url' => route('websites.index'),
                    'route_name' => 'websites.index',
                    'icon' => 'monitor-cellphone'
                ],
                [
                    'name' => "APIs",
                    'url' => '/apis',
                    'route_name' => 'apis',
                    'icon' => 'code-braces'
                ],
                [
                    'name' => 'Assertions',
                    'url' => '/assertions',
                    'route_name' => 'assertions',
                    'icon' => 'check'
                ],
                [
                    'name' => "Alerts",
                    'url' => '/alerts',
                    'route_name' => 'alerts',
                    'icon' => 'bell-outline'
                ],
                [
                    'name' => "Settings",
                    'url' => '/settings',
                    'route_name' => 'settings',
                    'icon' => 'settings'
                ],
            ]
        @endphp

        @foreach($items as $item)
            <a href="{{ $item['url'] }}" class="text-white text-justify no-underline italic text-gray-600 font-bold hover:text-gray-800 {{ \Illuminate\Support\Facades\Request::routeIs($item['route_name']) ? 'text-gray-800' : '' }}">
                <li class="leading-tight py-2 mb-2 text-sm px-8 hover:border-teal-600 border-l-4 hover:bg-gray-200 {{ \Illuminate\Support\Facades\Request::routeIs($item['route_name']) ? 'border-teal-600 bg-gray-200' : '' }}">
                    <span class="mr-4 mdi mdi-{{ $item['icon'] }} text-lg {{ \Illuminate\Support\Facades\Request::routeIs($item['route_name']) ? 'text-teal-600' : 'text-gray-500' }}"></span> {{ $item['name'] }}
                </li>
            </a>
        @endforeach
    </ul>
</div>

