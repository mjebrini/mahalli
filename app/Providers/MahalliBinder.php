<?php

namespace Mahalli\Providers;

use Illuminate\Support\ServiceProvider;
use Mahalli\Repositories\Customer\SiteRepository;

class MahalliBinder extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {   
        // register the SiteRepository
        $this->app->singleton(SiteRepository::class, function ($app) {
            return new SiteRepository();
        });
    }
}
