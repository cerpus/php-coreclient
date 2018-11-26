<?php

namespace Cerpus\CoreClient\DataObjects;


use Cerpus\CoreClient\Traits\CreateTrait;

/**
 * Class EditorBehaviorSettingsDataObject
 * @package Cerpus\CoreClient\DataObjects
 *
 * @method static EditorBehaviorSettingsDataObject create($attributes = null)
 */
class EditorBehaviorSettingsDataObject extends BaseDataObject
{

    use CreateTrait;

    /**
     * Setting to display "Text overrides and translations".
     * True = hide in editor(default)
     * False = show in editor
     *
     * @var bool
     */
    public $hideTextAndTranslations = true;

    public static $rules = [
        'hideTextAndTranslations' => 'boolean',
    ];
}