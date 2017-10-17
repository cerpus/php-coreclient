<?php

namespace Cerpus\CoreClient\Adapters;

use Cerpus\CoreClient\Contracts\CoreContract;
use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Response;
use Log;

/**
 * Class CoreAdapter
 * @package Cerpus\CoreClient\Adapters
 */
class CoreAdapter implements CoreContract
{
    /** @var ClientInterface */
    private $client;

    /** @var \Exception */
    private $error;

    /**
     * CoreAdapter constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param Questionset $questionset
     * @return bool|QuestionsetResponse
     */
    public function createQuestionset(Questionset $questionset)
    {
        try {
            $response = $this->client->request('POST', 'v1/contenttypes/questionsets', [
                'json' => $questionset->toArray()
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

    /**
     * @return null|\Exception
     */
    public function getError()
    {
        return $this->error;
    }
}