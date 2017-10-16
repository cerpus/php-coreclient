<?php

namespace Cerpus\CoreClient;

use Cerpus\CoreClient\Contracts\CoreContract;
use Illuminate\Support\Facades\Facade;

class CoreClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CoreContract::class;
    }

    public static function getBasePath()
    {
        return dirname(__DIR__);
    }
}