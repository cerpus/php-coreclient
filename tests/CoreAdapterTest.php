<?php

namespace Cerpus\CoreClientTests;

use Cerpus\CoreClient\Adapters\CoreAdapter;
use Cerpus\CoreClient\CoreClient;
use Cerpus\CoreClient\DataObjects\Answer;
use Cerpus\CoreClient\DataObjects\BehaviorSettingsDataObject;
use Cerpus\CoreClient\DataObjects\MultiChoiceQuestion;
use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use Cerpus\CoreClient\Exception\HttpException;
use Cerpus\CoreClient\Exception\MalformedResponseException;
use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\TestCase;

class CoreAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function createQuestionset_validData_thenSuccess()
    {
        $faker = Factory::create();
        $url = $faker->url;
        $text = $faker->sentence;

        $client = $this->createMock(ClientInterface::class);
        $client->method("request")->willReturnCallback(function () use ($url, $text) {
            $response = (new Response(\Illuminate\Http\Response::HTTP_OK, [], json_encode([
                'contentType' => CoreClient::H5P_QUESTIONSET,
                'url' => $url,
                'returnType' => "lti_launch_url",
                'text' => $text,
            ])));
            return $response;
        });

        /** @var ClientInterface $client */
        $coreAdapter = new CoreAdapter($client);
        $this->assertInstanceOf(CoreAdapter::class, $coreAdapter);

        /** @var MultiChoiceQuestion $question */
        $question = MultiChoiceQuestion::create([
            'text' => $faker->sentence
        ]);

        $answers = collect([
            Answer::create([
                'text' => $faker->sentence,
                'correct' => true
            ]),
            Answer::create([
                'text' => $faker->sentence,
                'correct' => false
            ]),
            Answer::create([
                'text' => $faker->sentence,
                'correct' => true
            ]),
        ]);
        $question->addAnswers($answers);

        /** @var Questionset $questionset */
        $questionset = Questionset::create([
            'title' => $faker->sentence,
            'authId' => $faker->uuid,
            'license' => "BY"
        ]);

        $this->assertEquals(0, $questionset->getScore());

        $questionset->addQuestion($question);

        $response = $coreAdapter->createQuestionSet($questionset);
        $this->assertInstanceOf(QuestionsetResponse::class, $response);

        $this->assertEquals($text, $response->text);
        $this->assertEquals($url, $response->urlToCore);
        $this->assertEquals(2, $questionset->getScore());
    }

    /**
     * @test
     */
    public function createQuestionset_emptyResponse_thenFailure()
    {
        $this->expectException(MalformedResponseException::class);

        $client = $this->createMock(ClientInterface::class);
        $client->method("request")->willReturnCallback(function () {
            return (new Response())->withStatus(\Illuminate\Http\Response::HTTP_OK);
        });

        /** @var ClientInterface $client */
        $coreAdapter = new CoreAdapter($client);
        $coreAdapter->createQuestionset(new Questionset());
    }

    /**
     * @test
     */
    public function validateBehaviorRequest()
    {
        $behaviorSettings = BehaviorSettingsDataObject::create();

        $trans = new Translator(new ArrayLoader(), "en");
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertTrue($validator->passes());

        $behaviorSettings->enableRetry = "yes";
        $trans = new Translator(new ArrayLoader(), "en");
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertFalse($validator->passes());
        $this->assertCount(1, $validator->getMessageBag());

        $behaviorSettings->presetmode = "vocal";
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertFalse($validator->passes());
        $this->assertCount(2, $validator->getMessageBag());

        $behaviorSettings->enableRetry = true;
        $behaviorSettings->presetmode = "vocal";
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertFalse($validator->passes());
        $this->assertCount(1, $validator->getMessageBag());

        $behaviorSettings->presetmode = "";
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertTrue($validator->passes());

        $behaviorSettings->presetmode = 'score';
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertTrue($validator->passes());

        $behaviorSettings->presetmode = 'exam';
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertTrue($validator->passes());

        $behaviorSettings->showSolution = 'on';
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertFalse($validator->passes());
        $this->assertCount(1, $validator->getMessageBag());

        $behaviorSettings->showSolution = false;
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertTrue($validator->passes());

        $behaviorSettings->includeAnswers = 'on';
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertFalse($validator->passes());
        $this->assertCount(1, $validator->getMessageBag());

        $behaviorSettings->includeAnswers = false;
        $validator = new Validator($trans, $behaviorSettings->toArray(), $behaviorSettings::$rules);
        $this->assertTrue($validator->passes());
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function publishResource_validUuid_thenSuccess(): void
    {
        $mock = new MockHandler([
            new Response(\Illuminate\Http\Response::HTTP_NO_CONTENT, [], ''),
        ]);

        $adapter = new CoreAdapter(new Client(['handler' => $mock]));
        $adapter->publishResource('07B53719-9560-46DF-AE08-52374BFC3A8E');
    }

    /**
     * @test
     */
    public function publishResource_badResponse_thenFailure(): void
    {
        $mock = new MockHandler([
            new RequestException(
                'Not found',
                new Request('PUT', 'v1/ltilinks/07B53719-9560-46DF-AE08-52374BFC3A8E/publish'),
                new Response(\Illuminate\Http\Response::HTTP_NOT_FOUND, [], 'Not found'),
            ),
        ]);

        $adapter = new CoreAdapter(new Client(['handler' => $mock]));

        $this->expectException(HttpException::class);
        $this->expectExceptionCode(\Illuminate\Http\Response::HTTP_NOT_FOUND);

        $adapter->publishResource('07B53719-9560-46DF-AE08-52374BFC3A8E');
    }

    /**
     * @test
     */
    public function publishResource_badUuid_thenFailure(): void
    {
        /** @var ClientInterface|\PHPUnit\Framework\MockObject\MockObject */
        $client = $this->createMock(ClientInterface::class);
        $adapter = new CoreAdapter($client);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Parameter 1 must be a valid UUID');

        $adapter->publishResource('jafashfjkahsfjkah');
    }
}
