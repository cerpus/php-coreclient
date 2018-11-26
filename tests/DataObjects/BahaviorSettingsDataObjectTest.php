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

        $behaviorSettings = BehaviorSettingsDataObject::create(true);
        $this->assertTrue($behaviorSettings->enableRetry);

        $behaviorSettings = BehaviorSettingsDataObject::create(false);
        $this->assertFalse($behaviorSettings->enableRetry);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => null,
        ]);
        $this->assertNull($behaviorSettings->enableRetry);
    }

}