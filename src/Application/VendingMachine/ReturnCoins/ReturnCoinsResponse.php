<?php

namespace VendingMachine\Application\VendingMachine\ReturnCoins;

use VendingMachine\Domain\VendingMachine\ValueObjects\Coin;

class ReturnCoinsResponse
{
    /** @var Coin[] */
    private array $coins;

    /**
     * @param Coin[] $coins
     */
    public function __construct(array $coins)
    {
        $this->coins = $coins;
    }

    public function getCoinValues(): array
    {
        return array_map(function ($coin) {
            /** @var Coin $coin */
            return $coin->getValue();
        }, $this->coins);
    }
}
