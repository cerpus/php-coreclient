<?php

namespace Cerpus\CoreClient\DataObjects;

use JsonSerializable;
use Cerpus\Helper\Traits\CreateTrait;

/**
 * Class EditorBehaviorSettingsDataObject
 * @package Cerpus\CoreClient\DataObjects
 *
 * @method static EditorBehaviorSettingsDataObject create($attributes = null)
 */
class EditorBehaviorSettingsDataObject extends BaseDataObject implements JsonSerializable
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

    private $behaviorSettings;

    public static $rules = [
        'hideTextAndTranslations' => 'boolean',
    ];

    public function setBehaviorSettings(BehaviorSettingsDataObject $settingsDataObject)
    {
        $this->behaviorSettings = $settingsDataObject;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}