<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

class MultiChoiceQuestion extends Question
{
    use CreateTrait;

    protected $type = self::H5P_MULTICHOICE;
}