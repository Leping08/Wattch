<?php

namespace App\Providers;

use App\Observers\PageObserver;
use App\Observers\WebsiteObserver;
use App\Page;
use App\Website;
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
        //
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
        Paginator::defaultView('vendor.pagination.tailwind-default');
        Paginator::defaultSimpleView('vendor.pagination.tailwind-simple');
    }
}
