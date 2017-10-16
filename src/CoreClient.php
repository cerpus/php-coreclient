<?php

namespace Cerpus\CoreClient;

use Cerpus\CoreClient\Contracts\CoreContract;
use Illuminate\Support\Facades\Facade;

class CoreClient extends Facade
{
    static $alias = "coreclient";

    protected static function getFacadeAccessor()
    {
        return CoreContract::class;
    }

    public static function getBasePath()
    {
        return dirname(__DIR__);
    }

    public static function getConfigPath()
    {
        return self::getBasePath() . '/src/Config/coreclient.php';
    }
}