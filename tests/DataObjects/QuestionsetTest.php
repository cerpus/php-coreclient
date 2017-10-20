<?php

namespace Cerpus\CoreClientTests\DataObjects;

use Cerpus\CoreClient\CoreClient;
use Cerpus\CoreClient\DataObjects\Answer;
use Cerpus\CoreClient\DataObjects\MultiChoiceQuestion;
use Cerpus\CoreClient\DataObjects\Questionset;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class QuestionsetTest extends TestCase
{

    /**
     * @test
     */
    public function Questionset_create_success()
    {
        $faker = Factory::create();
        $title = $faker->sentence;
        $license = "BY-SA";
        $authId = $faker->uuid;

        $questionset = new Questionset();
        $questionset->title = $title;
        $questionset->license = $license;
        $questionset->authId = $authId;

        $createQuestionset = Questionset::create([
            'license' => $license,
            'title' => $title,
            'authId' => $authId
        ]);

        $this->assertEquals($questionset, $createQuestionset);
    }

    /**
     * @test
     */
    public function Questionset_toArray_success()
    {
        $faker = Factory::create();
        $title = $faker->sentence;
        $license = "BY-SA";
        $authId = $faker->uuid;

        $questionset = new Questionset();
        $questionset->title = $title;
        $questionset->license = $license;
        $questionset->authId = $authId;

        $questionText1 = $faker->sentence;
        $answerText1 = $faker->sentence;
        $answerText2 = $faker->sentence;
        $answerText3 = $faker->sentence;

        $question = MultiChoiceQuestion::create([
            'text' => $questionText1,
        ]);

        $answers = collect([
            Answer::create([
                'text' => $answerText1,
                'correct' => false,
            ]),
            Answer::create([
                'text' => $answerText2,
                'correct' => true,
            ]),
            Answer::create([
                'text' => $answerText3,
                'correct' => false,
            ])
        ]);

        $question->addAnswers($answers);
        $questionset->addQuestion($question);

        $toArray = [
            'authId' => $authId,
            'license' => $license,
            'title' => $title,
            'type' => CoreClient::H5P_QUESTIONSET,
            'questions' => [
                [
                    'text' => $questionText1,
                    'type' => CoreClient::H5P_MULTICHOICE,
                    'answers' => [
                        [
                            'text' => $answerText1,
                            'correct' => false,
                        ],
                        [
                            'text' => $answerText2,
                            'correct' => true,
                        ],
                        [
                            'text' => $answerText3,
                            'correct' => false,
                        ],
                    ]
                ]
            ],
            'sharing' => false,
        ];

        $this->assertEquals($toArray, $questionset->toArray());

        $questionset->setSharing(true);
        $toArray['sharing'] = true;
        $this->assertEquals($toArray, $questionset->toArray());
    }

}
