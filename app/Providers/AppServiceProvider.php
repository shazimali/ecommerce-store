<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\API\Admin\Collections\CollectionInterface::class,
            \App\Services\API\Admin\Collections\CollectionsService::class
        );
        $this->app->bind(
            \App\Interfaces\API\Admin\Products\ProductInterface::class,
            \App\Services\API\Admin\Products\ProductService::class
        );
        $this->app->bind(
            \App\Interfaces\API\Admin\Products\ProductPriceInterface::class,
            \App\Services\API\Admin\Products\ProductPriceService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
