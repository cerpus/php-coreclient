<?php

namespace Cerpus\CoreClient\Adapters;

use Cerpus\CoreClient\Contracts\CoreContract;
use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use GuzzleHttp\ClientInterface;

class CoreAdapter implements CoreContract
{
    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createQuestionset(Questionset $questionset): QuestionsetResponse
    {
        try {
            $response = $this->client->request('POST', '/url/to/core', [
                'json' => [
                    $questionset
                ]
            ])->getBody();
            if (empty($response)) {
                throw new \Exception("Empty response");
            }
            $responseContent = json_decode($response);
            /** @var QuestionsetResponse $questionsetResponse */
            $questionsetResponse = QuestionsetResponse::create([
                'id' => $responseContent->id,
                'urlToCore' => $responseContent->url
            ]);
            return $questionsetResponse;
        } catch (\Exception $exception) {
        }
        return false;
    }
}