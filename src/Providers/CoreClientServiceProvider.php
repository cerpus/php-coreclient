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
        $this->app->bind(CoreContract::class, function ($app){
            $coreclient = $app['config']->get("coreclient");
            $client = $coreclient['adapter']['client']::getClient($coreclient);
            return new $coreclient['adapter']['current']($client);
        });

        $this->mergeConfigFrom(__DIR__ . "/../Config/coreclient.php", "coreclient");
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [CoreContract::class];
    }

}