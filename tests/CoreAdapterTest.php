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
    use Cerpus\CoreClient\DataObjects\MultiChoiceQuestion;
    use Cerpus\CoreClient\DataObjects\Questionset;
    use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
    use Faker\Factory;
    use GuzzleHttp\ClientInterface;
    use GuzzleHttp\Psr7\Response;
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
            $questionset->addQuestion($question);

            $response = $coreAdapter->createQuestionSet($questionset);
            $this->assertInstanceOf(QuestionsetResponse::class, $response);

            $this->assertEquals($text, $response->text);
            $this->assertEquals($url, $response->urlToCore);
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
            $response = $coreAdapter->createQuestionset(new Questionset());
        }
    }
}