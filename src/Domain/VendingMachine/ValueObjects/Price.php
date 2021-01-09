<?php

namespace VendingMachine\Domain\VendingMachine\ValueObjects;

class Price
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
