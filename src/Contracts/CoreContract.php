<?php

namespace Cerpus\CoreClient\Contracts;


use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;

/**
 * Interface CoreContract
 * @package Cerpus\CoreClient\Contracts
 */
interface CoreContract
{
    /**
     * @param Questionset $questionset
     * @return bool|QuestionsetResponse
     */
    public function createQuestionSet(Questionset $questionset);

    /**
     * @return null|\Exception
     */
    public function getError();

}