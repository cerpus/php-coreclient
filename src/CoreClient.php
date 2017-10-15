<?php

namespace Cerpus\CoreClient;


use Illuminate\Contracts\Config\Repository;

class CoreClient
{
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }
}