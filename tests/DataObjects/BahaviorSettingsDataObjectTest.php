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
        $this->assertNull($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create(true);
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create(true, true);
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertTrue($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create(false);
        $this->assertFalse($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create(false, false);
        $this->assertFalse($behaviorSettings->enableRetry);
        $this->assertFalse($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => null,
        ]);
        $this->assertNull($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => null,
            'autoCheck' => null,
        ]);
        $this->assertNull($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => true,
            'autoCheck' => true,
        ]);
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertTrue($behaviorSettings->autoCheck);
    }

}