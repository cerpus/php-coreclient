<?php

namespace Cerpus\CoreClient\Contracts;


use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use Cerpus\CoreClient\Exception\CoreClientException;

/**
 * Interface CoreContract
 * @package Cerpus\CoreClient\Contracts
 */
interface CoreContract
{
    /**
     * @param Questionset $questionset
     * @return bool|QuestionsetResponse
     * @throws CoreClientException
     */
    public function createQuestionSet(Questionset $questionset);

    public function publishResource(string $id): void;
}
