<?php

namespace Cerpus\CoreClient\Contracts;

use GuzzleHttp\ClientInterface;

interface CoreClientContract
{
    public static function getClient($config): ClientInterface;
}