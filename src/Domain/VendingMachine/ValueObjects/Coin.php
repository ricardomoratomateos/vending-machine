<?php

namespace VendingMachine\Domain\VendingMachine\ValueObjects;

use VendingMachine\Domain\VendingMachine\ValueObjects\Exceptions\InvalidCoinValueException;

class Coin
{
    private float $value;

    public function __construct(float $value)
    {
        $this->setValue($value);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    private function setValue(float $value): void
    {
        $acceptedValues = [0.05, 0.10, 0.25, 1];

        if (!in_array($value, $acceptedValues)) {
            throw new InvalidCoinValueException();
        }

        $this->value = $value;
    }
}
