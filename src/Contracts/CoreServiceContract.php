<?php

namespace Cerpus\CoreClient\Contracts;

use Cerpus\CoreClient\DataObjects\QuestionsetResponse;
use Cerpus\CoreClient\DataObjects\Questionset;

interface CoreServiceContract
{
    public function createQuestionset(Questionset $questionset): QuestionsetResponse;
}