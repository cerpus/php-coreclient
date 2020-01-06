<?php

namespace Cerpus\CoreClient\Contracts;

use Cerpus\Helper\DataObjects\OauthSetup;
use GuzzleHttp\ClientInterface;

/**
 * Interface CoreClientContract
 * @package Cerpus\CoreClient\Contracts
 */
interface CoreClientContract
{
    /**
     * @param OauthSetup $config
     * @return ClientInterface
     */
    public static function getClient(OauthSetup $config): ClientInterface;
}