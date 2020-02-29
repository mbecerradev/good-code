<?php

declare(strict_types = 1);

namespace GoodCode;

class AboveMaximumDistanceException extends \Exception
{
    private function __construct()
    {
    }

    public static function withValue(float $value): self
    {
        return new static(sprintf('Distance %.2f is above the maximum allowed value', $value));
    }
}
