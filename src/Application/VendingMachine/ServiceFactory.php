<?php

namespace VendingMachine\Application\VendingMachine;

use VendingMachine\Domain\VendingMachine\Repositories\VendingMachineRepositoryInterface;

class ServiceFactory
{
    protected VendingMachineRepositoryInterface $repository;

    public function __construct(
        VendingMachineRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function make(string $class)
    {
        return new $class($this->repository);
    }
}
