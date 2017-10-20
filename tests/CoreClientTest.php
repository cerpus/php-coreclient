<?php
/**
 * Created by PhpStorm.
 * User: tsivert
 * Date: 10/16/17
 * Time: 11:30 AM
 */

namespace Cerpus\CoreClientTests;

use Cerpus\CoreClient\CoreClient;
use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
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


    /**
     * @test
     */
    public function createQuestionset_validData_thenSuccess()
    {
        $title = "My first questionset";

        CoreClient::shouldReceive('createQuestionset')
            ->once()
            ->andReturn(QuestionsetResponse::create([
                'text' => $title
            ]));

        $questionset = new Questionset();
        $questionset->title = $title;

        $response = CoreClient::createQuestionset($questionset);
        $this->assertInstanceOf(QuestionsetResponse::class, $response);
        $this->assertEquals($questionset->title, $response->text);
    }
}
