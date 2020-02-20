<?php

declare(strict_types = 1);

namespace GoodCodeTest;

use GoodCode\Distance;
use PHPUnit\Framework\TestCase;

final class DistanceTest extends TestCase
{
    public function testExceptionTestsAreWorking()
    {
        $this->expectException(\Exception::class);
        throw new \Exception("testing exceptions!");
    }

    public function testAssertions()
    {
        $somethingTrue = true;
        $this->assertSame($somethingTrue, true);
    }

    public function testSomething()
    {
        $distance = new Distance();
        $distance->setMeters(15);
        $this->assertSame($distance->meters(), 15.0);
    }
}
