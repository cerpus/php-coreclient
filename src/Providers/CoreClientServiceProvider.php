<?php

namespace Cerpus\CoreClient\Providers;


use Cerpus\Helper\Clients\Client;
use Cerpus\Helper\Clients\JWT;
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
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            CoreClient::getConfigPath() => config_path('coreclient.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(CoreClientContract::class, function ($app, $params) {
            $coreclient = $app['config']->get("coreclient");
            $client = $params['authClient'] ?? strtolower($coreclient['adapter']['client']);
            /** @var CoreClientContract $clientClass */
            switch ($client) {
                case "oauth1":
                case Oauth1Client::class:
                    $clientClass = Oauth1Client::class;
                    break;
                case "oauth2":
                case Oauth2Client::class:
                    $clientClass = Oauth2Client::class;
                    break;
                case "jwt":
                case JWT::class:
                    $clientClass = JWT::class;
                    break;
                default:
                    $clientClass = Client::class;
                    break;
            }

            return $clientClass::getClient(OauthSetup::create([
                'coreUrl' => $coreclient['core']['url'],
                'key' => $coreclient['core']['key'],
                'secret' => $coreclient['core']['secret'],
                'authUser' => $coreclient['auth']['user'],
                'authSecret' => $coreclient['auth']['secret'],
                'authUrl' => $coreclient['auth']['url'],
                'token' => $coreclient['core']['token'],
                'tokenSecret' => $coreclient['core']['token_secret'],
            ]));
        });

        $this->app->bind(CoreContract::class, function ($app, $params) {
            $coreclient = $app['config']->get("coreclient");
            $client = $params['authentication'] ?? $app->make(CoreClientContract::class, $params);
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
        return [
            CoreContract::class,
            CoreClientContract::class
        ];
    }

}
