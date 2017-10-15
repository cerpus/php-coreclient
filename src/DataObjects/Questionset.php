<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

class Questionset
{
    use CreateTrait;

    public $authId, $license, $title;
    private $questions;
    private $sharing = false;

    public function __construct()
    {
        $this->questions = collect();
    }

    public function addQuestion(MultiChoiceQuestion $question)
    {
        $this->questions->push($question);
    }

    public function setSharing(bool $sharing)
    {
        $this->sharing = $sharing;
    }
}