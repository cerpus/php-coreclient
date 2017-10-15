<?php

namespace Cerpus\CoreClient\Contracts;

use GuzzleHttp\ClientInterface;

interface CoreClientContract
{
    public function getClient($config): ClientInterface;
}