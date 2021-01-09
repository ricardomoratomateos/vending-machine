<?php

namespace VendingMachine\Application\VendingMachine\InsertCoin;

use VendingMachine\Application\VendingMachine\AbstractService;

class InsertCoinService extends AbstractService
{
    public function __invoke(
        InsertCoinRequest $request
    ): InsertCoinResponse {
        $vendingMachine = $this->repository->getVendingMachine();

        $coin = $request->getCoin();
        $vendingMachine->insertCoin($coin);

        $this->repository->save($vendingMachine);

        return new InsertCoinResponse(true);
    }
}
