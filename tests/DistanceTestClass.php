<?php


namespace GoodCodeTest;

use GoodCode\Distance;

class DistanceTestClass extends Distance
{
    protected function getMaximumDistanceAllowed(): float
    {
        return floatval(10000);
    }
}
