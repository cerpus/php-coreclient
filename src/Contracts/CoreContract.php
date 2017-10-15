<?php

namespace Cerpus\CoreClient\Contracts;


use Cerpus\CoreClient\DataObjects\Questionset;
use Cerpus\CoreClient\DataObjects\QuestionsetResponse;

interface CoreContract
{
    public function createQuestionSet(Questionset $questionset): QuestionsetResponse;

}