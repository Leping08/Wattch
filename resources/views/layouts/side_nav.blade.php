<div class="fixed mt-16 w-64 min-h-screen bg-gray-100 shadow-md pt-4">
    <ul class="list-reset">
        @php
            $items = [
                [
                    'name' => 'Dashboard',
                    'url' => route('dashboard'),
                    'route_name' => 'dashboard',
                    'icon' => 'view-dashboard',
                    'active' => \Illuminate\Support\Facades\Request::segment(1) == 'dashboard'
                ],
                [
                    'name' => 'Websites',
                    'url' => route('websites.index'),
                    'route_name' => route('websites.index'),
                    'icon' => 'monitor-cellphone',
                    'active' => \Illuminate\Support\Facades\Request::segment(1) == 'websites'
                ],
                [
                    'name' => "APIs",
                    'url' => '/apis',
                    'route_name' => 'apis',
                    'icon' => 'code-braces',
                    'active' => \Illuminate\Support\Facades\Request::segment(1) == 'api'
                ],
                [
                    'name' => 'Assertions',
                    'url' => '/assertions',
                    'route_name' => 'assertions',
                    'icon' => 'format-list-checks',
                    'active' => \Illuminate\Support\Facades\Request::segment(1) == 'assertions'
                ],
                [
                    'name' => "Alerts",
                    'url' => '/alerts',
                    'route_name' => 'alerts',
                    'icon' => 'bell-outline',
                    'active' => \Illuminate\Support\Facades\Request::segment(1) == 'alerts'
                ],
                [
                    'name' => "Settings",
                    'url' => route('settings.account.index'),
                    'route_name' => 'settings',
                    'icon' => 'settings',
                    'active' => \Illuminate\Support\Facades\Request::segment(1) == 'settings'
                ],
            ]
        @endphp

        @foreach($items as $item)
            <a href="{{ $item['url'] }}" class="text-white text-justify no-underline italic text-gray-600 font-bold hover:text-gray-800 {{ $item['active'] ? 'text-gray-800' : '' }}">
                <li class="leading-tight py-2 mb-2 text-sm px-8 hover:border-teal-600 border-l-4 hover:bg-gray-200 {{ $item['active'] ? 'border-teal-600 bg-gray-200' : '' }}">
                    <span class="mr-4 mdi mdi-{{ $item['icon'] }} text-lg {{ $item['active'] ? 'text-teal-600' : 'text-gray-500' }}"></span> {{ $item['name'] }}
                </li>
            </a>
        @endforeach
    </ul>
</div>

