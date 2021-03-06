<?php

namespace Cerpus\CoreClient;

use Cerpus\CoreClient\Contracts\CoreContract;
use Illuminate\Support\Facades\Facade;

/**
 * Class CoreClient
 * @package Cerpus\CoreClient
 */
class CoreClient extends Facade
{
    /**
     * @var string
     */
    static $alias = "coreclient";

    const H5P_MULTICHOICE = "H5P.MultiChoice";
    const H5P_QUESTIONSET = "H5P.QuestionSet";

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CoreContract::class;
    }

    /**
     * @return string
     */
    public static function getBasePath()
    {
        return dirname(__DIR__);
    }

    /**
     * @return string
     */
    public static function getConfigPath()
    {
        return self::getBasePath() . '/src/Config/coreclient.php';
    }
}