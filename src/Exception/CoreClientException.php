<?php

namespace Cerpus\CoreClient\Exception;

use GuzzleHttp\Exception\InvalidArgumentException as GuzzleInvalidArgumentException;
use GuzzleHttp\Exception\TransferException;

class CoreClientException extends \Exception
{
    public static function fromGuzzleException(\Throwable $e)
    {
        // bad HTTP request - may or may not have a status code
        if ($e instanceof TransferException) {
            return new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        // handle GuzzleHttp\json_decode
        if ($e instanceof GuzzleInvalidArgumentException && strpos($e->getMessage(), 'json_decode') === 0) {
            return new MalformedResponseException('json_decode failed', 0, $e);
        }

        // unknown Guzzle error that we don't handle
        throw $e;
    }
}
