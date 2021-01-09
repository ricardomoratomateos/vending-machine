<?php

namespace VendingMachine\Application\VendingMachine;

use VendingMachine\Domain\VendingMachine\Repositories\VendingMachineRepositoryInterface;

abstract class AbstractService
{
    protected VendingMachineRepositoryInterface $repository;

    public function __construct(
        VendingMachineRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
}
