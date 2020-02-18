<?php

declare(strict_types = 1);

namespace GoodCode\Lesson1;


class Distance
{
    private $meters;

    public function __construct(float $meters)
    {
        if ($meters >= 0) {
            $this->meters = $meters;
        } else {
            throw new NegativeDistanceException("Distance must be positive");
        }
    }

    public function meters(): float
    {
        return $this->meters;
    }
}
