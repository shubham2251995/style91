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
        // Register Plugin Manager
        $this->app->singleton(\App\Services\PluginManager::class, function ($app) {
            return new \App\Services\PluginManager();
        });

        // Share Menus
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('menus')) {
                \Illuminate\Support\Facades\View::composer(['components.layouts.app', 'components.layouts.footer'], function ($view) {
                    $view->with('headerMenu', \App\Models\Menu::where('location', 'header')->with('items.children')->first());
                    $view->with('footerMenu1', \App\Models\Menu::where('location', 'footer_1')->with('items')->first());
                    $view->with('footerMenu2', \App\Models\Menu::where('location', 'footer_2')->with('items')->first());
                });
            }
        } catch (\Exception $e) {
            // Log or ignore if DB not ready
        }

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
