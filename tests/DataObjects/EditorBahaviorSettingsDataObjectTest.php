<?php

namespace tests\DataObjects;


use Cerpus\CoreClient\DataObjects\BehaviorSettingsDataObject;
use Cerpus\CoreClient\DataObjects\EditorBehaviorSettingsDataObject;
use PHPUnit\Framework\TestCase;

class EditorBahaviorSettingsDataObjectTest extends TestCase
{

    /** @test */
    public function createDataObject()
    {
        $editorBehaviorSettings = EditorBehaviorSettingsDataObject::create();
        $this->assertTrue($editorBehaviorSettings->hideTextAndTranslations);

        $editorBehaviorSettings = EditorBehaviorSettingsDataObject::create(true);
        $this->assertTrue($editorBehaviorSettings->hideTextAndTranslations);

        $editorBehaviorSettings = EditorBehaviorSettingsDataObject::create(false);
        $this->assertFalse($editorBehaviorSettings->hideTextAndTranslations);

        $behaviorSettings = BehaviorSettingsDataObject::create(true);
        $this->assertTrue($behaviorSettings->enableRetry);

        $editorBehaviorSettings->setBehaviorSettings($behaviorSettings);

        $decoded = json_decode($editorBehaviorSettings->toJson());
        $this->assertFalse($decoded->hideTextAndTranslations);
        $this->assertNotNull($decoded->behaviorSettings);
        $this->assertTrue($decoded->behaviorSettings->enableRetry);
    }

}