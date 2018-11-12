<?php

namespace tests\DataObjects;


use Cerpus\CoreClient\DataObjects\BehaviorSettingsDataObject;
use PHPUnit\Framework\TestCase;

class BahaviorSettingsDataObjectTest extends TestCase
{

    /** @test */
    public function createDataObject()
    {
        /** @var BehaviorSettingsDataObject $behaviorSettings */
        $behaviorSettings = BehaviorSettingsDataObject::create();
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertFalse($behaviorSettings->overrideFeedback);

        /** @var BehaviorSettingsDataObject $behaviorSettings */
        $behaviorSettings = BehaviorSettingsDataObject::create(false);
        $this->assertFalse($behaviorSettings->enableRetry);
        $this->assertFalse($behaviorSettings->overrideFeedback);

        /** @var BehaviorSettingsDataObject $behaviorSettings */
        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => null,
            'overrideFeedback' => false
        ]);
        $this->assertNull($behaviorSettings->enableRetry);
        $this->assertFalse($behaviorSettings->overrideFeedback);

        /** @var BehaviorSettingsDataObject $behaviorSettings */
        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => false,
            'overrideFeedback' => true
        ]);
        $this->assertFalse($behaviorSettings->enableRetry);
        $this->assertTrue($behaviorSettings->overrideFeedback);
    }

}