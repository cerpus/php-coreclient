<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

class OauthSetup
{
    use CreateTrait;

    public $key, $secret, $coreUrl, $authUrl;
}