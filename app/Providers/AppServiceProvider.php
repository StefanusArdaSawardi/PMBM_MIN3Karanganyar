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
            
            // Fetch school contacts dynamically with a fallback
            $schoolContacts = collect();
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('school_contacts')) {
                    $schoolContacts = \App\Models\SchoolContact::all();
                }
            } catch (\Exception $e) {
                // Failsafe before migration runs
            }
 
            $view->with('landingContent', $landingContent)
                 ->with('schoolContacts', $schoolContacts);
        });
    }
}
