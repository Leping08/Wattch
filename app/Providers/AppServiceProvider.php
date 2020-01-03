<?php

namespace App\Providers;

use App\Observers\PageObserver;
use App\Observers\UserObserver;
use App\Observers\WebsiteObserver;
use App\Page;
use App\User;
use App\Website;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind('HttpClient', function () {
            return (new Client(['verify' => false]));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Page::observe(PageObserver::class);
        Website::observe(WebsiteObserver::class);
        User::observe(UserObserver::class);
        Paginator::defaultView('vendor.pagination.tailwind-default');
        Paginator::defaultSimpleView('vendor.pagination.tailwind-simple');
    }
}
