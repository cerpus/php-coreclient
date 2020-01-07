<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\CoreClient;
use Cerpus\Helper\Traits\CreateTrait;

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
    protected $type = CoreClient::H5P_MULTICHOICE;
}