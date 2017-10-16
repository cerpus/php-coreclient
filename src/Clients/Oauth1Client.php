<?php

namespace Cerpus\CoreClient\Clients;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use Cerpus\CoreClient\DataObjects\OauthSetup;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Client;

class Oauth1Client implements CoreClientContract
{

    public static function getClient(OauthSetup $config): ClientInterface
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key' => $config->key,
            'consumer_secret' => $config->secret,
            'token' => $config->token,
            'token_secret' => $config->tokenSecret,
        ]);

        $stack->push($middleware);

        return new Client([
            'base_uri' => $config->coreUrl,
            'handler' => $stack,
            RequestOptions::AUTH => 'oauth',
        ]);
    }
}