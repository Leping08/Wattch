<?php

namespace App\Providers;

use App\Models\Assertion;
use App\Models\AssertionResult;
use App\Models\Page;
use App\Policies\AssertionPolicy;
use App\Policies\AssertionResultPolicy;
use App\Policies\PagePolicy;
use App\Policies\WebsitePolicy;
use App\Models\Website;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Website::class => WebsitePolicy::class,
        Page::class => PagePolicy::class,
        Assertion::class => AssertionPolicy::class,
        AssertionResult::class => AssertionResultPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
