<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        if (env('APP_ENV') == 'production') {
            $this->app['request']->server->set('HTTPS', true);
            
            // Check if manifest is in .vite subdirectory
            if (file_exists(public_path('build/.vite/manifest.json'))) {
                Vite::useBuildDirectory('build/.vite');
            } else {
                Vite::useBuildDirectory('build');
            }
        }
    }
}