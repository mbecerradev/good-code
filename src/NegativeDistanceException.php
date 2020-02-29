<?php

declare(strict_types = 1);

namespace GoodCode;

class NegativeDistanceException extends \Exception
{
    private function __construct()
    {
    }

    public static function withValue(float $value): self
    {
        return new static(sprintf('Distance %.2f must be positive', $value));
    }
}
