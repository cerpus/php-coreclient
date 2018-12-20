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
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create(true);
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create(true, true);
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertTrue($behaviorSettings->autoCheck);
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create(false);
        $this->assertFalse($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create(false, false);
        $this->assertFalse($behaviorSettings->enableRetry);
        $this->assertFalse($behaviorSettings->autoCheck);
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => null,
        ]);
        $this->assertNull($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => null,
            'autoCheck' => null,
        ]);
        $this->assertNull($behaviorSettings->enableRetry);
        $this->assertNull($behaviorSettings->autoCheck);
        $this->assertNull($behaviorSettings->presetmode);
        $this->assertNull($behaviorSettings->showSolution);
        $this->assertTrue($behaviorSettings->includeAnswers);

        $behaviorSettings = BehaviorSettingsDataObject::create([
            'enableRetry' => true,
            'autoCheck' => true,
            'showSolution' => true,
            'presetmode' => 'score',
            'includeAnswers' => false,
        ]);
        $this->assertTrue($behaviorSettings->enableRetry);
        $this->assertTrue($behaviorSettings->autoCheck);
        $this->assertEquals('score', $behaviorSettings->presetmode);
        $this->assertTrue($behaviorSettings->showSolution);
        $this->assertFalse($behaviorSettings->includeAnswers);
    }

}