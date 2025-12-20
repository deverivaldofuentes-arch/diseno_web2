<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Forzar HTTPS en producción (Railway siempre usa HTTPS)
        if(env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
