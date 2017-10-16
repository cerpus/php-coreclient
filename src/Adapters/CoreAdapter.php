<?php

namespace Cerpus\CoreClient\Adapters;

use Cerpus\CoreClient\Contracts\CoreContract;
use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Response;
use Log;

class CoreAdapter implements CoreContract
{
    /** @var ClientInterface */
    private $client;

    private $error;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createQuestionset(Questionset $questionset)
    {
        try {
            $response = $this->client->request('POST', '/url/to/core', [
                'json' => [
                    $questionset
                ]
            ]);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new \Exception(sprintf("Unexpected response code(%s) with reason: %s", $response->getStatusCode(), $response->getReasonPhrase()));
            }

            $responseBody = $response->getBody();
            if (empty($responseBody->getSize())) {
                throw new \Exception("Empty response");
            }
            $responseContent = json_decode($responseBody);
            /** @var QuestionsetResponse $questionsetResponse */
            $questionsetResponse = QuestionsetResponse::create([
                'id' => $responseContent->id,
                'urlToCore' => $responseContent->url
            ]);
            return $questionsetResponse;
        } catch (\Exception $exception) {
            $this->error = $exception;
            Log::error(__METHOD__ . ': (' . $exception->getCode() . ') ' . $exception->getMessage());
        }
        return false;
    }

    public function getError()
    {
        return $this->error;
    }
}