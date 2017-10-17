<?php

namespace Cerpus\CoreClient\DataObjects;

use Cerpus\CoreClient\Traits\CreateTrait;

/**
 * Class Answer
 * @package Cerpus\CoreClient\DataObjects
 */
class Answer
{
    use CreateTrait;

    /**
     * @var string
     */
    public $text;
    /**
     * @var bool
     */
    public $correct = false;

}