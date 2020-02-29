<?php

declare(strict_types = 1);

namespace GoodCodeTest;

use GoodCode\AboveMaximumDistanceException;
use GoodCode\DistanceConfiguration;
use GoodCode\NegativeDistanceException;
use PHPUnit\Framework\TestCase;

final class DistanceTest extends TestCase
{
    public function testNegativeDistancesAreInvalid()
    {
        $this->expectException(NegativeDistanceException::class);
        DistanceTestClass::measure(-0.01);
    }

    public function testDistancesStayBelowMaximum()
    {
        $this->expectException(AboveMaximumDistanceException::class);
        DistanceTestClass::measure(10000.01);
    }

    private function assertDistanceIsValid($distance, $validValue)
    {
        $this->assertIsFloat($distance->meters());
        $this->assertIsFloat($validValue);
        $this->assertSame($distance->meters(), $validValue);
    }

    public function testValidDistanceWithMinimumValue()
    {
        $this->assertDistanceIsValid(DistanceTestClass::measure(0), 0.0);
    }

    public function testValidDistanceWithMaximumValue()
    {
        $this->assertDistanceIsValid(DistanceTestClass::measure(10000), 10000.0);
    }

    public function testAddDistancesReturnsAnotherDistanceWithAddedValues()
    {
        $distance1 = DistanceTestClass::measure(150);
        $distance2 = DistanceTestClass::measure(50);
        $distance3 = $distance1->add($distance2);

        $this->assertSame($distance3->meters(), 200.0);
        $this->assertNotSame($distance1, $distance3);
        $this->assertNotSame($distance1, $distance2);
        $this->assertNotSame($distance2, $distance3);
    }

    public function testDistanceIsSmall()
    {
        $distance = DistanceTestClass::measure(100);
        $this->assertTrue($distance->isSmall(new class implements DistanceConfiguration
        {
            public function getSmallDistanceValue(): float
            {
                return 100;
            }
        }));
    }

    public function testDistanceIsNotSmall()
    {
        $distance = DistanceTestClass::measure(100.01);
        $this->assertFalse($distance->isSmall(new class implements DistanceConfiguration
        {
            public function getSmallDistanceValue(): float
            {
                return 100;
            }
        }));
    }

    public function testMeasureDistanceFromBuilding()
    {
        $distance = DistanceTestClass::measureFromBuilding(new class {
            public function getMeasures()
            {
                return $this;
            }

            public function getHeight()
            {
                return $this;
            }

            public function toMeters()
            {
                return 100;
            }
        });
        $this->assertDistanceIsValid($distance, 100.0);
    }
}
