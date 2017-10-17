<?php

namespace Cerpus\CoreClient\Clients;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use Cerpus\CoreClient\DataObjects\OauthSetup;
use GuzzleHttp\ClientInterface;

/**
 * Class Client
 * @package Cerpus\CoreClient\Clients
 */
class Client implements CoreClientContract
{

    /**
     * @param OauthSetup $config
     * @return ClientInterface
     */
    public static function getClient(OauthSetup $config): ClientInterface
    {
        return new \GuzzleHttp\Client([
            'base_uri' => $config->coreUrl,
        ]);
    }
}