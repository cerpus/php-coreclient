<?php

namespace Cerpus\CoreClient\Providers;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use Cerpus\CoreClient\Contracts\CoreContract;
use Illuminate\Support\ServiceProvider;

class CoreClientServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CoreClientContract::class, function ($app){
            $auth = $app['config']->get("auth");
            $adapter = $app['config']->get("adapter");
            $clientClass = $adapter['client'];
            return new $clientClass();
        });

        $this->app->bind(CoreContract::class, function ($app){

            $adapter = $app['config']->get("adapter");
            //return new $class($app['config']['groups']);
        });

        $this->app->alias(CoreContract::class, 'coreclient');

        $this->mergeConfigFrom(__DIR__ . "/config/coreclient.php",  "coreclient");
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [CoreContract::class, CoreClientContract::class];
    }

}