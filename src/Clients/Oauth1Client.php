<?php

namespace Cerpus\CoreClient\Clients;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Client;

class Oauth1Client implements CoreClientContract
{

    public function getClient($config): ClientInterface
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key' => null,
            'consumer_secret' => null,
        ]);

        $stack->push($middleware);

        return new Client([
            'base_uri' => 'url/to/auth',
            'handler' => $stack,
            RequestOptions::AUTH => 'oauth',
        ]);
    }
}