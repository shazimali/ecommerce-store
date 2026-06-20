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
        $this->app->bind(
            \App\Interfaces\API\Admin\Bundles\BundleInterface::class,
            \App\Services\API\Admin\Bundles\BundleService::class
        );
        $this->app->bind(
            \App\Interfaces\API\Admin\Bundles\BundlePriceInterface::class,
            \App\Services\API\Admin\Bundles\BundlePriceService::class
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
