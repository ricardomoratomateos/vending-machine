<?php

namespace VendingMachine\Application\VendingMachine\ReturnCoins;

use VendingMachine\Application\VendingMachine\AbstractService;

class ReturnCoinsService extends AbstractService
{
    public function __invoke(
        ReturnCoinsRequest $request
    ): ReturnCoinsResponse {
        $vendingMachine = $this->repository->getVendingMachine();

        $coins = $vendingMachine->returnCoins();

        $this->repository->save($vendingMachine);

        return new ReturnCoinsResponse($coins);
    }
}
