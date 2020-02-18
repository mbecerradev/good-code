<?php

declare(strict_types = 1);

namespace GoodCodeTest;

use GoodCode\Lesson1\Distance;
use GoodCode\Lesson1\NegativeDistanceException;
use PHPUnit\Framework\TestCase;

final class DistanceTest extends TestCase
{
    public function testCreateANegativeDistance()
    {
        $this->expectException(NegativeDistanceException::class);
        new Distance(-1);
    }

    public function testCreateValidDistance()
    {
        $distance = new Distance(0);
        $this->assertSame($distance->meters(), 0.0);
    }
}
