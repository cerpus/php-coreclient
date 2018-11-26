<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

/**
 * Class BehaviorSettingsDataObject
 * @package Cerpus\CoreClient\DataObjects
 *
 * @method static BehaviorSettingsDataObject create($attributes = null)
 */
class BehaviorSettingsDataObject extends BaseDataObject
{

    use CreateTrait;

    /**
     * Setting to override the logic to retry a H5P in the learners view.
     * True = enables retry
     * False = disables retry
     * Null = use value set on the resource(default)
     *
     * @var bool|null
     */
    public $enableRetry;

    public static $rules = [
        'enableRetry' => 'boolean|nullable',
    ];
}