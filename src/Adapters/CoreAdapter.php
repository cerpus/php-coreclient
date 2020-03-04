<?php

namespace Cerpus\CoreClient\Adapters;

use Cerpus\CoreClient\Contracts\CoreContract;
use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use Cerpus\CoreClient\Exception\CoreClientException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use function GuzzleHttp\json_decode as guzzle_json_decode;

/**
 * Class CoreAdapter
 * @package Cerpus\CoreClient\Adapters
 */
class CoreAdapter implements CoreContract
{
    /** @var ClientInterface */
    private $client;

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
     * @return QuestionsetResponse
     * @throws CoreClientException
     */
    public function createQuestionset(Questionset $questionset)
    {
        try {
            $response = $this->client->request('POST', 'v1/contenttypes/questionsets', [
                'json' => $questionset->toArray()
            ]);

            $responseContent = guzzle_json_decode($response->getBody()->getContents());
            /** @var QuestionsetResponse $questionsetResponse */
            $questionsetResponse = QuestionsetResponse::create([
                'returnType' => $responseContent->returnType,
                'contentType' => $responseContent->contentType,
                'urlToCore' => $responseContent->url,
                'text' => $responseContent->text
            ]);
            return $questionsetResponse;
        } catch (GuzzleException $e) {
            throw CoreClientException::fromGuzzleException($e);
        }
    }

    public function publishResource(string $id): void
    {
        if (!Str::isUuid($id)) {
            throw new \InvalidArgumentException('Parameter 1 must be a valid UUID');
        }

        try {
            $this->client->request('PUT', sprintf('v1/ltilinks/%s/publish', $id));
        } catch (GuzzleException $e) {
            throw CoreClientException::fromGuzzleException($e);
        }
    }
}
