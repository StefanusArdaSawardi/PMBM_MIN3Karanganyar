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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $contentPath = storage_path('app/landing_content.json');
            $landingContent = [];
            if (file_exists($contentPath)) {
                $landingContent = json_decode(file_get_contents($contentPath), true);
            }
            $view->with('landingContent', $landingContent);
        });
    }
}
