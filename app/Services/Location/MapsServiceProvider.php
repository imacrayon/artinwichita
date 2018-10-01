<?php

namespace App\Services\Maps;

use Illuminate\Support\ServiceProvider;

class MapsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('geocoder', function ($app) {
            return new Geocoder(config('services.google.client_secret'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'geocoder'
        ];
    }
}
