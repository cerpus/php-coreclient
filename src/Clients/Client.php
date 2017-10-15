<?php

namespace Cerpus\CoreClient\Clients;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use GuzzleHttp\ClientInterface;

class Client implements CoreClientContract
{

    public static function getClient($config): ClientInterface
    {
        return new \GuzzleHttp\Client([
            'base_uri' => config('services.contentAuthor.url'),
        ]);
    }
}