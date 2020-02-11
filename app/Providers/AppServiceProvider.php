<?php

namespace App\Providers;

use App\Assertion;
use App\Observers\AssertionObserver;
use App\Observers\PageObserver;
use App\Observers\ScreenshotScheduleObserver;
use App\Observers\UserObserver;
use App\Observers\WebsiteObserver;
use App\Page;
use App\ScreenshotSchedule;
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
            return new Client(['verify' => false]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Assertion::observe(AssertionObserver::class);
        Page::observe(PageObserver::class);
        Website::observe(WebsiteObserver::class);
        User::observe(UserObserver::class);
        ScreenshotSchedule::observe(ScreenshotScheduleObserver::class);
        Paginator::defaultView('vendor.pagination.tailwind-default');
        Paginator::defaultSimpleView('vendor.pagination.tailwind-simple');
    }
}
