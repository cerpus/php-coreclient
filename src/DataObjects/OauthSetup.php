<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

/**
 * Class OauthSetup
 * @package Cerpus\CoreClient\DataObjects
 */
class OauthSetup
{
    use CreateTrait;

    /**
     * @var string $key
     * @var string $secret
     * @var string $coreUrl
     * @var string $authUrl
     * @var string $tokenSecret
     * @var string $token
     */
    public $key, $secret, $coreUrl, $authUrl, $tokenSecret, $token;
}