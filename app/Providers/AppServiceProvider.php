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
        }
        
        // Fix Vite manifest path
        Vite::useBuildDirectory('build');
    }
}