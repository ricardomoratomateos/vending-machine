<?php

namespace VendingMachine\Application\VendingMachine\InsertCoin;

class InsertCoinResponse
{
    private bool $coinWasInserted;

    public function __construct(bool $coinWasInserted)
    {
        $this->coinWasInserted = $coinWasInserted;
    }

    public function coinWasInserted(): bool
    {
        return $this->coinWasInserted;
    }
}
