<?php

namespace Cerpus\CoreClient\Contracts;

use Cerpus\CoreClient\DataObjects\OauthSetup;
use GuzzleHttp\ClientInterface;

interface CoreClientContract
{
    public static function getClient(OauthSetup $config): ClientInterface;
}