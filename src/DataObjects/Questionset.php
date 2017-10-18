<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\CoreClient;
use Cerpus\CoreClient\Traits\CreateTrait;

/**
 * Class Questionset
 * @package Cerpus\CoreClient\DataObjects
 */
class Questionset
{
    use CreateTrait;

    /** @var string $authId */
    /** @var string $licence */
    /** @var string $title */
    public $authId, $license, $title;

    public static $type = CoreClient::H5P_QUESTIONSET;

    /** @var \Illuminate\Support\Collection */
    private $questions;
    /** @var bool */
    private $sharing = false;

    /**
     * Questionset constructor.
     */
    public function __construct()
    {
        $this->questions = collect();
    }

    /**
     * @param MultiChoiceQuestion $question
     */
    public function addQuestion(MultiChoiceQuestion $question)
    {
        $this->questions->push($question);
    }

    /**
     * @param bool $sharing
     */
    public function setSharing(bool $sharing)
    {
        $this->sharing = $sharing;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @return bool
     */
    public function getSharing()
    {
        return $this->sharing;
    }
}