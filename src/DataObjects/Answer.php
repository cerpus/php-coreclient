<?php

namespace Cerpus\CoreClient\DataObjects;

use Cerpus\Helper\Traits\CreateTrait;

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