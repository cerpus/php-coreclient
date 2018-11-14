<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

class BehaviorSettingsDataObject extends BaseDataObject
{

    use CreateTrait;

    /**
     * @var bool|null
     *
     * Value null lets Edlib determine the behavior
     */
    public $enableRetry = true;

    /**
     * @var bool|null
     *
     * Value null lets Edlib determine the behavior
     */
    public $overrideFeedback = false;

    public static $rules = [
        'enableRetry' => 'boolean|nullable',
        'overrideFeedback' => 'boolean|nullable',
    ];
}