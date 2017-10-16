<?php

namespace Cerpus\CoreClient\Clients;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use Cerpus\CoreClient\DataObjects\OauthSetup;
use GuzzleHttp\ClientInterface;

class Client implements CoreClientContract
{

    public static function getClient(OauthSetup $config): ClientInterface
    {
        return new \GuzzleHttp\Client([
            'base_uri' => $config->coreUrl,
        ]);
    }
}