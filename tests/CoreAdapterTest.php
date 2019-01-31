<?php

namespace {
    class Log
    {
        public function error()
        {
        }
    }
}

namespace Cerpus\CoreClientTests {

    use Cerpus\CoreClient\Adapters\CoreAdapter;
    use Cerpus\CoreClient\CoreClient;
    use Cerpus\CoreClient\DataObjects\Answer;
    use Cerpus\CoreClient\DataObjects\BehaviorSettingsDataObject;
    use Cerpus\CoreClient\DataObjects\MultiChoiceQuestion;
    use Cerpus\CoreClient\DataObjects\Questionset;
    use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
    use Faker\Factory;
    use GuzzleHttp\ClientInterface;
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
         * @expectedException \Exception
         * @expectedExceptionMessage Empty response
         */
        public function createQuestionset_emptyResponse_thenFailure()
        {
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
    }
}