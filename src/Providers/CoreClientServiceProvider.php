<?php

namespace Cerpus\CoreClient\Providers;


use Cerpus\Helper\Clients\Client;
use Cerpus\Helper\Clients\Oauth1Client;
use Cerpus\Helper\Clients\Oauth2Client;
use Cerpus\CoreClient\Contracts\CoreClientContract;
use Cerpus\CoreClient\Contracts\CoreContract;
use Cerpus\CoreClient\CoreClient;
use Cerpus\Helper\DataObjects\OauthSetup;
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

        $this->app->bind(CoreClientContract::class, function ($app) {
            $coreclient = $app['config']->get("coreclient");
            $client = strtolower($coreclient['adapter']['client']);
            /** @var CoreClientContract $clientClass */
            switch ($client) {
                case "oauth1":
                    $clientClass = Oauth1Client::class;
                    break;
                case "oauth2":
                    $clientClass = Oauth2Client::class;
                    break;
                default:
                    $clientClass = Client::class;
                    break;
            }

            return $clientClass::getClient(OauthSetup::create([
                'coreUrl' => $coreclient['core']['url'],
                'key' => $coreclient['core']['key'],
                'secret' => $coreclient['core']['secret'],
                'authUrl' => $coreclient['auth']['url'],
                'token' => $coreclient['core']['token'],
                'token_secret' => $coreclient['core']['token_secret'],
            ]));
        });

        $this->app->bind(CoreContract::class, function ($app) {
            $coreclient = $app['config']->get("coreclient");
            $client = $app->make(CoreClientContract::class);
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