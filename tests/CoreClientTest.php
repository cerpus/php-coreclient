<?php
/**
 * Created by PhpStorm.
 * User: tsivert
 * Date: 10/16/17
 * Time: 11:30 AM
 */

namespace Tests;

use Cerpus\CoreClient\CoreClient;
use PHPUnit\Framework\TestCase;

class CoreClientTest extends TestCase
{

    /**
     * @test
     */
    public function getBasedir()
    {
        $this->assertEquals(dirname(__DIR__), CoreClient::getBasePath());
    }

    /**
     * @test
     */
    public function getConfigPath()
    {
        $this->assertEquals(dirname(__DIR__) . '/src/Config/coreclient.php', CoreClient::getConfigPath());
    }
}
