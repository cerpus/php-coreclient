<?php

namespace Cerpus\CoreClient\DataObjects;

use Cerpus\CoreClient\Traits\CreateTrait;

class Answer
{
    use CreateTrait;

    public $text;
    public $correct = false;

}