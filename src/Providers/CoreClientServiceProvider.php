<?php

namespace Cerpus\CoreClient\Providers;


use Cerpus\CoreClient\Clients\Client;
use Cerpus\CoreClient\Contracts\CoreContract;
use Cerpus\CoreClient\CoreClient;
use Cerpus\CoreClient\DataObjects\OauthSetup;
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
            $clientClass = $coreclient['adapter']['client'];
            if (empty($clientClass)) {
                $clientClass = Client::class;
            }

            $client = $clientClass::getClient(OauthSetup::create([
                'coreUrl' => $coreclient['core']['url'],
                'key' => $coreclient['core']['key'],
                'secret' => $coreclient['core']['secret'],
                'authUrl' => $coreclient['auth']['url'],
                'token' => $coreclient['core']['token'],
                'token_secret' => $coreclient['core']['token_secret'],
            ]));
            return new $coreclient['adapter']['current']($client);
        });

        $this->mergeConfigFrom(CoreClient::getConfigPath(), CoreClient::$alias);
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