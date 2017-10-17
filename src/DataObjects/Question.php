<?php

namespace Cerpus\CoreClient\DataObjects;

use Illuminate\Support\Collection;

/**
 * Class Question
 * @package Cerpus\CoreClient\DataObjects
 */
abstract class Question
{
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    protected $type;

    /**
     * @var Collection
     */
    protected $answers;

    const H5P_MULTICHOICE = "H5P.MultiChoice";

    /**
     * Question constructor.
     */
    public function __construct()
    {
        $this->answers = collect();
    }

    /**
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer){
        $this->answers->push($answer);
    }

    /**
     * @param Collection $answers
     */
    public function addAnswers(Collection $answers)
    {
        $that = $this;
        $answers->each(function($answer) use ($that){
            $that->addAnswer($answer);
        });
    }

    /**
     * @return Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }
}