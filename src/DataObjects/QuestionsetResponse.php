<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\Helper\Traits\CreateTrait;

/**
 * Class QuestionsetResponse
 * @package Cerpus\CoreClient\DataObjects
 */
class QuestionsetResponse
{
    use CreateTrait;

    /**
     * @var string
     */
    public $urlToCore;
    /**
     * @var string
     */
    public $contentType;

    /**
     * @var string
     */
    public $returnType;

    /**
     * @var string
     */
    public $text;

}