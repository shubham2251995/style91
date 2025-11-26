<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\PluginManager::class, function ($app) {
            return new \App\Services\PluginManager();
        });

        $this->app->singleton(\App\Services\CartService::class, function ($app) {
            return new \App\Services\CartService();
        });

        $this->app->singleton(\App\Services\AnalyticsService::class, function ($app) {
            return new \App\Services\AnalyticsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        
        // Register Blade directive for plugin checks
        \Illuminate\Support\Facades\Blade::if('plugin', function ($key) {
            return app(\App\Services\PluginManager::class)->isActive($key);
        });
        
        // if($this->app->environment('production') || $this->app->environment('staging')) {
        //     \Illuminate\Support\Facades\URL::forceScheme('https');
        // }
    }
}
