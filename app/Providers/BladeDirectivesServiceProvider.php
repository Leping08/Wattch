<?php


namespace App\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('baby', function () {
            return "<?php if((auth()->user()->product()->id ?? 1) >= 1): ?>";
        });

        Blade::directive('security', function () {
            return "<?php if((auth()->user()->product()->id ?? 1) >= 2): ?>";
        });

        Blade::directive('pi', function () {
            return "<?php if((auth()->user()->product()->id ?? 1) >= 3): ?>";
        });

        Blade::directive('endproduct', function () {
            return "<?php endif; ?>";
        });
    }
}