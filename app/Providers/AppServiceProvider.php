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
        // Registrar helpers si existen
        $this->registerHelpers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Registrar archivos helper
     */
    private function registerHelpers(): void
    {
        $helpersPath = app_path('Helpers');
        
        if (is_dir($helpersPath)) {
            $helperFiles = glob($helpersPath . '/*.php');
            
            foreach ($helperFiles as $file) {
                require_once $file;
            }
        }
    }
}