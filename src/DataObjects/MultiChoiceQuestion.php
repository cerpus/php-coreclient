<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

/**
 * Class MultiChoiceQuestion
 * @package Cerpus\CoreClient\DataObjects
 */
class MultiChoiceQuestion extends Question
{
    use CreateTrait;

    /**
     * @var string
     */
    protected $type = self::H5P_MULTICHOICE;
}