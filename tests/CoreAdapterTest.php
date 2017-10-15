<?php

namespace Tests;

use Cerpus\CoreClient\Adapters\CoreAdapter;
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
        $id = $faker->randomDigitNotNull;

        $client = $this->createMock(ClientInterface::class);
        $client->method("request")->willReturnCallback(function () use ($url, $id) {
            $response = (new Response(200, [], json_encode([
                'id' => $id,
                'url' => $url
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

        $this->assertEquals($id, $response->id);
        $this->assertEquals($url, $response->urlToCore);
    }
}
