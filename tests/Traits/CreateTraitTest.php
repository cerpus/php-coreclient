<?php

namespace Cerpus\CoreClientTests\Traits;

use Cerpus\Helper\Traits\CreateTrait;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class Truck
{

    use CreateTrait;

    public $color;
    public $maxWeight;

    protected $model = "UltraSuper GT 3000";

    private $cargo;
    private $full = false;

    public function __construct()
    {
        $this->cargo = collect();
    }

    public function setFull(bool $full)
    {
        $this->full = $full;
    }

    public function addCargo(Cargo $cargo)
    {
        $this->cargo->push($cargo);
    }
}

class Cargo
{

    use CreateTrait;

    public $weight;
    public $fragile = false;

    private $content;

    public function __construct()
    {
        $this->content = collect();
    }

    public function addContent(Content $content)
    {
        $this->content->push($content);
    }
}

class Content
{
    public $type;
    public $name;
}

class CreateTraitTest extends TestCase
{

    /**
     * @test
     */
    public function createTruck()
    {
        $faker = Factory::create();

        $color = $faker->colorName;
        $maxWeight = $faker->numberBetween(1, 500);

        $truck = new Truck();
        $truck->color = $color;
        $truck->maxWeight = $maxWeight;
        $truck->setIsDirty(true);

        $truck2 = Truck::create([
            'color' => $color,
            'maxWeight' => $maxWeight,
        ]);

        $this->assertEquals($truck, $truck2);

        $truck->setFull(true);
        $truck2 = Truck::create([
            'color' => $color,
            'maxWeight' => $maxWeight,
            'full' => true
        ]);
        $this->assertEquals($truck, $truck2);
    }

    /**
     * @test
     */
    public function truckAndCargoToArray()
    {
        $faker = Factory::create();
        $color = $faker->colorName;
        $maxWeight = 500;

        $weight = $faker->numberBetween(1, 500);
        /** @var Truck $truck */
        $truck = Truck::create([
            'color' => $color,
            'maxWeight' => $maxWeight,
        ]);

        /** @var Cargo $cargo */
        $cargo = Cargo::create([
            'weight' => $weight
        ]);

        $truck->addCargo($cargo);

        $toArray = [
            'color' => $color,
            'maxWeight' => $maxWeight,
            'model' => "UltraSuper GT 3000",
            'cargo' => [
                [
                    'weight' => $weight,
                    'fragile' => false,
                    'content' => []
                ]
            ],
            'full' => false,
        ];

        $this->assertEquals($toArray, $truck->toArray());

        $content = new Content();
        $content->type = "Glass";
        $content->name = "Rosendal";

        $cargo->addContent($content);
        $toArray['cargo'][0]['content'][] = $content;

        $this->assertEquals($toArray, $truck->toArray());
    }
}
