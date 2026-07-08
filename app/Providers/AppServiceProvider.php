<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Force https:// on all generated URLs when running in production.
        // Ensures canonical links, OG tags, sitemap URLs, and media URLs are
        // all https even when PHP is behind Hostinger's reverse proxy.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

