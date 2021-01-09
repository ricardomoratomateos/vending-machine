<?php

namespace VendingMachine\Application\VendingMachine\InsertCoin;

use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;

class InsertCoinRequest
{
    private Coin $coin;

    public function __construct(float $value)
    {
        $this->coin = new Coin($value);
    }

    public function getCoin(): Coin
    {
        return $this->coin;
    }
}
