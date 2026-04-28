<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
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
        if ($this->shouldServeBuiltAssets()) {
            // Force public hosts (ngrok/LAN/etc.) to use the compiled assets
            // instead of the local Vite dev server referenced by public/hot.
            Vite::useHotFile(storage_path('framework/vite.hot.disabled'));
        }
    }

    protected function shouldServeBuiltAssets(): bool
    {
        if ($this->app->runningInConsole()) {
            return false;
        }

        if (! file_exists(public_path('build/manifest.json'))) {
            return false;
        }

        $host = request()->getHost();

        return ! in_array($host, ['127.0.0.1', '::1', 'localhost'], true)
            && ! str_ends_with($host, '.localhost')
            && ! str_ends_with($host, '.test');
    }
}
