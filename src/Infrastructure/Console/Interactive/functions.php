<?php

use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinRequest;
use VendingMachine\Application\VendingMachine\InsertCoin\InsertCoinService;
use VendingMachine\Application\VendingMachine\ReturnCoins\ReturnCoinsRequest;
use VendingMachine\Application\VendingMachine\ReturnCoins\ReturnCoinsResponse;
use VendingMachine\Application\VendingMachine\ReturnCoins\ReturnCoinsService;
use VendingMachine\Application\VendingMachine\ServiceFactory;
use VendingMachine\Application\VendingMachine\VendItem\VendItemRequest;
use VendingMachine\Application\VendingMachine\VendItem\VendItemResponse;
use VendingMachine\Application\VendingMachine\VendItem\VendItemService;
use VendingMachine\Domain\LogicException;

function processInsertCoin(ServiceFactory $serviceFactory)
{
    echo "Type the coin value (0.05, 0.10, 0.25, 1.00): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);

    $coinValue = (float)trim($line);

    try {
        $request = new InsertCoinRequest($coinValue);
        /** @var InsertMoneyService */
        $service = $serviceFactory->make(InsertCoinService::class);

        $service($request);
    } catch (LogicException $exception) {
        echo $exception::MESSAGE;
        echo "\n";
    }

    fclose($handle);
}

function processReturnCoins(ServiceFactory $serviceFactory)
{
    try {
        $request = new ReturnCoinsRequest();
        /** @var ReturnCoinsService */
        $service = $serviceFactory->make(ReturnCoinsService::class);

        /** @var ReturnCoinsResponse */
        $response = $service($request);

        $coinValues = $response->getCoinValues();
        if (empty($coinValues)) {
            echo "Any coins to return.";
            echo "\n";
            return;
        }

        echo implode(', ', $coinValues);
        echo "\n";
    } catch (LogicException $exception) {
        echo $exception::MESSAGE;
        echo "\n";
    }
}

function processVendItem(ServiceFactory $serviceFactory)
{
    echo "Type the item (juice, soda, water): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);

    $item = trim($line);

    try {
        $request = new VendItemRequest("item-$item");
        /** @var VendItemService */
        $service = $serviceFactory->make(VendItemService::class);

        /** @var VendItemResponse */
        $response = $service($request);

        $coinValues = $response->getChange();
        if (empty($coinValues)) {
            echo "Any change to return.";
            echo "\n";
            return;
        }

        echo implode(', ', $coinValues) . ', ' . $response->getItem();
        echo "\n";
    } catch (LogicException $exception) {
        echo $exception::MESSAGE;
        echo "\n";
    }

    fclose($handle);
}
