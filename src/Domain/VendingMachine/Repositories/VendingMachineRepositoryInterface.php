<?php

namespace VendingMachine\Domain\VendingMachine\Repositories;

use VendingMachine\Domain\VendingMachine\VendingMachine;

interface VendingMachineRepositoryInterface
{
    public function getVendingMachine(): VendingMachine;

    public function save(VendingMachine $vendingMachine): void;
}
